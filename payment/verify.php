<?php
require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/gateways.php';
header('Content-Type: application/json; charset=utf-8');
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') { http_response_code(405); echo json_encode(['ok'=>false]); exit; }
$token = (string) ($_POST['token'] ?? '');
$payment = payment_find_by_token($con, $token);
if (!$payment || $payment['gateway'] !== 'razorpay' || $payment['status'] === 'paid') { echo json_encode(['ok'=>(bool)($payment && $payment['status']==='paid')]); exit; }
$orderId = (string) ($_POST['razorpay_order_id'] ?? '');
$paymentId = (string) ($_POST['razorpay_payment_id'] ?? '');
$signature = (string) ($_POST['razorpay_signature'] ?? '');
if ($orderId === '' || $paymentId === '' || $signature === '' || !hash_equals((string)$payment['gatewayOrderId'], $orderId)) { http_response_code(400); echo json_encode(['ok'=>false]); exit; }
$config = payment_gateway_configs()['razorpay'];
$expected = hash_hmac('sha256', $orderId . '|' . $paymentId, $config['secret']);
if (!hash_equals($expected, $signature) || !payment_verify_razorpay_payment($payment, $paymentId)) { http_response_code(400); echo json_encode(['ok'=>false]); exit; }
echo json_encode(['ok'=>payment_mark_received($con, (int)$payment['paymentId'], $paymentId)]);
