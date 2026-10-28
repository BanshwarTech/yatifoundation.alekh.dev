<?php
declare(strict_types=1);
require_once __DIR__ . '/../Includes/env.php';

function payment_gateway_configs(): array
{
    $cashfreeMode = strtolower((string) (getenv('CASHFREE_ENVIRONMENT') ?: 'sandbox')) === 'production' ? 'production' : 'sandbox';
    return [
        'razorpay' => [
            'label' => 'Razorpay',
            'key_id' => (string) (getenv('RAZORPAY_KEY_ID') ?: ''),
            'secret' => (string) (getenv('RAZORPAY_KEY_SECRET') ?: ''),
            'webhook_secret' => (string) (getenv('RAZORPAY_WEBHOOK_SECRET') ?: ''),
            'enabled' => (string) (getenv('RAZORPAY_KEY_ID') ?: '') !== '' && (string) (getenv('RAZORPAY_KEY_SECRET') ?: '') !== '',
        ],
        'cashfree' => [
            'label' => 'Cashfree',
            'app_id' => (string) (getenv('CASHFREE_APP_ID') ?: ''),
            'secret' => (string) (getenv('CASHFREE_SECRET_KEY') ?: ''),
            'webhook_secret' => (string) (getenv('CASHFREE_WEBHOOK_SECRET') ?: ''),
            'mode' => $cashfreeMode,
            'api_base' => $cashfreeMode === 'production' ? 'https://api.cashfree.com/pg' : 'https://sandbox.cashfree.com/pg',
            'enabled' => (string) (getenv('CASHFREE_APP_ID') ?: '') !== '' && (string) (getenv('CASHFREE_SECRET_KEY') ?: '') !== '',
        ],
    ];
}

function payment_available_gateways(): array
{
    return array_filter(payment_gateway_configs(), static fn(array $gateway): bool => $gateway['enabled']);
}

function payment_base_url(): string
{
    $configured = trim((string) (getenv('SITE_BASE_URL') ?: ''));
    if ($configured !== '') return rtrim($configured, '/');
    $host = preg_replace('/[^a-zA-Z0-9.\-:\[\]]/', '', (string) ($_SERVER['HTTP_HOST'] ?? 'localhost')) ?: 'localhost';
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    $script = (string) ($_SERVER['SCRIPT_NAME'] ?? '/');
    $root = str_replace('\\', '/', dirname(dirname($script)));
    if ($root === '/' || $root === '.') $root = '';
    return ($https ? 'https://' : 'http://') . $host . rtrim($root, '/');
}

function payment_http(string $gateway, string $method, string $url, array $payload = []): array
{
    if (!function_exists('curl_init')) return ['ok' => false, 'status' => 0, 'data' => null];
    $configs = payment_gateway_configs();
    $config = $configs[$gateway] ?? null;
    if (!$config || !$config['enabled']) return ['ok' => false, 'status' => 0, 'data' => null];
    $headers = ['Accept: application/json', 'Content-Type: application/json'];
    if ($gateway === 'razorpay') {
        $headers[] = 'Authorization: Basic ' . base64_encode($config['key_id'] . ':' . $config['secret']);
    } else {
        $headers[] = 'x-client-id: ' . $config['app_id'];
        $headers[] = 'x-client-secret: ' . $config['secret'];
        $headers[] = 'x-api-version: 2025-01-01';
    }
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST => strtoupper($method),
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 25,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ]);
    if ($payload) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_SLASHES));
    $body = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    $data = is_string($body) ? json_decode($body, true) : null;
    return ['ok' => $status >= 200 && $status < 300 && is_array($data), 'status' => $status, 'data' => is_array($data) ? $data : null];
}

function payment_create_provider_order(string $gateway, string $internalOrderId, int $donationId, string $amount, string $name, string $email, string $mobile): ?array
{
    $base = payment_base_url();
    if ($gateway === 'razorpay') {
        $paise = (int) round(((float) $amount) * 100);
        $result = payment_http('razorpay', 'POST', 'https://api.razorpay.com/v1/orders', [
            'amount' => $paise, 'currency' => 'INR', 'receipt' => $internalOrderId,
            'notes' => ['donation_id' => (string) $donationId],
        ]);
        if (!$result['ok'] || empty($result['data']['id'])) return null;
        return ['order_id' => (string) $result['data']['id'], 'session_id' => null, 'amount_minor' => $paise];
    }
    if ($gateway === 'cashfree') {
        $phone = preg_replace('/\D+/', '', $mobile);
        $result = payment_http('cashfree', 'POST', payment_gateway_configs()['cashfree']['api_base'] . '/orders', [
            'order_id' => $internalOrderId,
            'order_amount' => (float) $amount,
            'order_currency' => 'INR',
            'customer_details' => [
                'customer_id' => 'donor_' . $donationId,
                'customer_name' => $name,
                'customer_email' => $email,
                'customer_phone' => $phone,
            ],
            'order_meta' => [
                'return_url' => $base . '/payment/return.php?token=' . rawurlencode($token) . '&order_id={order_id}',
                'notify_url' => $base . '/payment/webhook.php?gateway=cashfree',
            ],
        ]);
        if (!$result['ok'] || empty($result['data']['order_id']) || empty($result['data']['payment_session_id'])) return null;
        return ['order_id' => (string) $result['data']['order_id'], 'session_id' => (string) $result['data']['payment_session_id'], 'amount_minor' => (int) round(((float) $amount) * 100)];
    }
    return null;
}

function payment_mark_received(mysqli $con, int $paymentId, string $gatewayPaymentId): bool
{
    mysqli_begin_transaction($con);
    try {
        $select = mysqli_prepare($con, 'SELECT donationId,status FROM donation_payments WHERE paymentId=? FOR UPDATE');
        mysqli_stmt_bind_param($select, 'i', $paymentId);
        mysqli_stmt_execute($select);
        $payment = mysqli_fetch_assoc(mysqli_stmt_get_result($select));
        mysqli_stmt_close($select);
        if (!$payment) { mysqli_rollback($con); return false; }
        if ($payment['status'] === 'paid') { mysqli_commit($con); return true; }
        $update = mysqli_prepare($con, "UPDATE donation_payments SET status='paid',gatewayPaymentId=?,updatedOn=NOW() WHERE paymentId=? AND status<>'paid'");
        mysqli_stmt_bind_param($update, 'si', $gatewayPaymentId, $paymentId);
        $ok = mysqli_stmt_execute($update);
        mysqli_stmt_close($update);
        if (!$ok) { mysqli_rollback($con); return false; }
        $donation = mysqli_prepare($con, "UPDATE donate SET status='Received' WHERE dId=?");
        mysqli_stmt_bind_param($donation, 'i', $payment['donationId']);
        $ok = mysqli_stmt_execute($donation);
        mysqli_stmt_close($donation);
        if (!$ok) { mysqli_rollback($con); return false; }
        mysqli_commit($con);
        return true;
    } catch (Throwable $error) {
        mysqli_rollback($con);
        error_log('Donation payment update failed: ' . $error->getMessage());
        return false;
    }
}

function payment_find_by_token(mysqli $con, string $token): ?array
{
    if (!preg_match('/^[a-f0-9]{64}$/', $token)) return null;
    $stmt = mysqli_prepare($con, 'SELECT * FROM donation_payments WHERE paymentToken=? LIMIT 1');
    if (!$stmt) return null;
    mysqli_stmt_bind_param($stmt, 's', $token);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt)) ?: null;
    mysqli_stmt_close($stmt);
    return $row;
}

function payment_verify_cashfree_order(array $payment): ?string
{
    $config = payment_gateway_configs()['cashfree'];
    $orderId = rawurlencode((string) $payment['gatewayOrderId']);
    $order = payment_http('cashfree', 'GET', $config['api_base'] . '/orders/' . $orderId);
    if (!$order['ok'] || ($order['data']['order_status'] ?? '') !== 'PAID' || strtoupper((string) ($order['data']['order_currency'] ?? '')) !== 'INR') return null;
    if (abs((float) ($order['data']['order_amount'] ?? 0) - (float) $payment['amount']) > 0.001) return null;
    $payments = payment_http('cashfree', 'GET', $config['api_base'] . '/orders/' . $orderId . '/payments');
    if (!$payments['ok'] || !is_array($payments['data'])) return null;
    foreach ($payments['data'] as $attempt) {
        if (($attempt['payment_status'] ?? '') === 'SUCCESS'
            && strtoupper((string) ($attempt['payment_currency'] ?? 'INR')) === 'INR'
            && abs((float) ($attempt['payment_amount'] ?? 0) - (float) $payment['amount']) <= 0.001) {
            return (string) ($attempt['cf_payment_id'] ?? $attempt['payment_id'] ?? 'cashfree-' . $payment['gatewayOrderId']);
        }
    }
    return null;
}

function payment_verify_razorpay_payment(array $payment, string $paymentId): bool
{
    $config = payment_gateway_configs()['razorpay'];
    $remote = payment_http('razorpay', 'GET', 'https://api.razorpay.com/v1/payments/' . rawurlencode($paymentId));
    if (!$remote['ok']) return false;
    $data = $remote['data'];
    return ($data['status'] ?? '') === 'captured'
        && (string) ($data['order_id'] ?? '') === (string) $payment['gatewayOrderId']
        && strtoupper((string) ($data['currency'] ?? '')) === 'INR'
        && (int) ($data['amount'] ?? 0) === (int) round(((float) $payment['amount']) * 100);
}

function payment_confirm_cashfree_webhook(mysqli $con, array $event): bool
{
    if (($event['type'] ?? '') !== 'PAYMENT_SUCCESS_WEBHOOK') return true;
    $order = $event['data']['order'] ?? [];
    $attempt = $event['data']['payment'] ?? [];
    if (($attempt['payment_status'] ?? '') !== 'SUCCESS' || strtoupper((string) ($attempt['payment_currency'] ?? '')) !== 'INR') return false;
    $orderId = (string) ($order['order_id'] ?? '');
    $stmt = mysqli_prepare($con, "SELECT paymentId,amount FROM donation_payments WHERE gateway='cashfree' AND gatewayOrderId=? LIMIT 1");
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, 's', $orderId);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    if (!$row || abs((float) ($attempt['payment_amount'] ?? 0) - (float) $row['amount']) > 0.001) return false;
    return payment_mark_received($con, (int) $row['paymentId'], (string) ($attempt['cf_payment_id'] ?? 'cashfree-' . $orderId));
}

function payment_confirm_razorpay_webhook(mysqli $con, array $event): bool
{
    if (($event['event'] ?? '') !== 'payment.captured') return true;
    $entity = $event['payload']['payment']['entity'] ?? [];
    $orderId = (string) ($entity['order_id'] ?? '');
    if (($entity['status'] ?? '') !== 'captured' || strtoupper((string) ($entity['currency'] ?? '')) !== 'INR') return false;
    $stmt = mysqli_prepare($con, "SELECT paymentId,amount FROM donation_payments WHERE gateway='razorpay' AND gatewayOrderId=? LIMIT 1");
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, 's', $orderId);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    if (!$row || (int) ($entity['amount'] ?? 0) !== (int) round(((float) $row['amount']) * 100)) return false;
    return payment_mark_received($con, (int) $row['paymentId'], (string) ($entity['id'] ?? ''));
}
