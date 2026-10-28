<?php
require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/gateways.php';
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') { http_response_code(405); exit; }
$raw = file_get_contents('php://input') ?: '';
$gateway = (string) ($_GET['gateway'] ?? '');
$configs = payment_gateway_configs();
if (!isset($configs[$gateway])) { http_response_code(400); exit; }
$valid = false;
if ($gateway === 'razorpay') {
    $signature = (string) ($_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '');
    $secret = (string) $configs['razorpay']['webhook_secret'];
    $valid = $secret !== '' && $signature !== '' && hash_equals(hash_hmac('sha256', $raw, $secret), $signature);
} elseif ($gateway === 'cashfree') {
    $signature = (string) ($_SERVER['HTTP_X_WEBHOOK_SIGNATURE'] ?? '');
    $timestamp = (string) ($_SERVER['HTTP_X_WEBHOOK_TIMESTAMP'] ?? '');
    $secret = (string) $configs['cashfree']['webhook_secret'];
    $expected = base64_encode(hash_hmac('sha256', $timestamp . $raw, $secret, true));
    $valid = $secret !== '' && $timestamp !== '' && $signature !== '' && hash_equals($expected, $signature);
}
if (!$valid) { http_response_code(401); exit; }
$event = json_decode($raw, true);
if (!is_array($event)) { http_response_code(400); exit; }
$processed = $gateway === 'razorpay' ? payment_confirm_razorpay_webhook($con, $event) : payment_confirm_cashfree_webhook($con, $event);
http_response_code($processed ? 200 : 422);
echo $processed ? 'ok' : 'payment verification failed';
