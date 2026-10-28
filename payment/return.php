<?php
session_start();
require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/gateways.php';
$token = (string) ($_GET['token'] ?? '');
$payment = payment_find_by_token($con, $token);
$verified = $payment && $payment['status'] === 'paid';
if ($payment && !$verified && $payment['gateway'] === 'cashfree' && hash_equals((string)$payment['gatewayOrderId'], (string)($_GET['order_id'] ?? ''))) {
    $providerPaymentId = payment_verify_cashfree_order($payment);
    if ($providerPaymentId !== null) $verified = payment_mark_received($con, (int)$payment['paymentId'], $providerPaymentId);
}
$title = $verified ? 'Donation confirmed' : 'Payment is being verified';
$message = $verified ? 'Thank you. The payment provider confirmed your contribution.' : 'The payment has not yet been confirmed. Please wait a little and contact the foundation if you were charged but this status does not update.';
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title><link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"><link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"><style>body{font-family:'DM Sans',sans-serif;background:#f4f7fb;color:#14213d;min-height:100vh;display:grid;place-items:center;padding:24px}.card{max-width:580px;padding:48px 36px;border:1px solid #e4eaf0;border-radius:24px;box-shadow:0 24px 70px #14213d12;text-align:center}.icon{font-size:2.5rem;color:<?php echo $verified?'#138a72':'#f3a32d'; ?>}</style></head><body><main class="card"><div class="icon mb-3"><?php echo $verified?'✓':'…'; ?></div><h1 class="h3 fw-bold"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1><p class="text-secondary"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p><a href="../index.php" class="btn btn-primary rounded-pill px-4 mt-2">Return to website</a></main></body></html>
