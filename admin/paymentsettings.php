<?php
require_once __DIR__ . '/includes/admin_helpers.php';
admin_require_auth();
require_once __DIR__ . '/../Includes/env.php';

$envPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
$managed = [
    'SITE_BASE_URL', 'RAZORPAY_KEY_ID', 'RAZORPAY_KEY_SECRET', 'RAZORPAY_WEBHOOK_SECRET',
    'CASHFREE_APP_ID', 'CASHFREE_SECRET_KEY', 'CASHFREE_WEBHOOK_SECRET', 'CASHFREE_ENVIRONMENT',
];
$notice = $_SESSION['app_toast'] ?? null;
unset($_SESSION['app_toast']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_require_post();
    $values = [];
    foreach ($managed as $key) {
        $old = getenv($key);
        $old = $old === false ? '' : (string) $old;
        $input = trim((string) ($_POST[$key] ?? ''));
        $clear = isset($_POST['clear'][$key]);
        $values[$key] = $clear ? '' : ($input !== '' ? $input : $old);
    }
    $values['CASHFREE_ENVIRONMENT'] = strtolower($values['CASHFREE_ENVIRONMENT']);
    $baseUrl = $values['SITE_BASE_URL'];
    if ($baseUrl !== '' && (!filter_var($baseUrl, FILTER_VALIDATE_URL) || !in_array(strtolower((string) parse_url($baseUrl, PHP_URL_SCHEME)), ['http', 'https'], true))) {
        $message = 'Enter a valid website URL starting with http:// or https://.';
        $type = 'warning';
    } elseif (!in_array($values['CASHFREE_ENVIRONMENT'], ['sandbox', 'production'], true)) {
        $message = 'Choose Sandbox or Production for Cashfree.';
        $type = 'warning';
    } else {
        $existing = is_file($envPath) ? file($envPath, FILE_IGNORE_NEW_LINES) : [];
        if (!is_array($existing)) $existing = [];
        $written = [];
        $seen = [];
        foreach ($existing as $line) {
            if (preg_match('/^\s*([A-Za-z_][A-Za-z0-9_]*)\s*=/', $line, $match) && in_array($match[1], $managed, true)) {
                $key = $match[1];
                if (!isset($seen[$key])) $written[] = $key . '=' . json_encode($values[$key], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                $seen[$key] = true;
            } else {
                $written[] = $line;
            }
        }
        foreach ($managed as $key) {
            if (!isset($seen[$key])) $written[] = $key . '=' . json_encode($values[$key], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        $payload = implode(PHP_EOL, $written) . PHP_EOL;
        if (file_put_contents($envPath, $payload, LOCK_EX) === false) {
            $message = 'Could not save .env. Check that the project root is writable by PHP.';
            $type = 'error';
        } else {
            foreach ($values as $key => $value) { putenv($key . '=' . $value); $_ENV[$key] = $value; }
            $message = 'Payment settings saved securely.';
            $type = 'success';
        }
    }
    $_SESSION['app_toast'] = ['message' => $message, 'type' => $type];
    header('Location: paymentsettings.php');
    exit;
}

$configured = static function (string $key): bool { $value = getenv($key); return $value !== false && $value !== ''; };
$csrf = admin_csrf_token();
?>
<!doctype html>
<html lang="en">
<?php $adminPageTitle = 'Payment Settings'; include __DIR__ . '/includes/head.php'; ?>
<body class="sb-nav-fixed">
<?php include __DIR__ . '/includes/topheader.php'; ?>
<div id="layoutSidenav"><div id="layoutSidenav_nav"><?php include __DIR__ . '/includes/sidebar.php'; ?></div>
<div id="layoutSidenav_content"><main><div class="container-fluid px-4">
    <div class="admin-page-heading mt-4"><div><span class="admin-eyebrow">Yati Foundation</span><h1>Payment settings</h1><p>Manage Razorpay and Cashfree checkout credentials for donations.</p></div></div>
    <?php if (!is_file($envPath) || !is_writable($envPath)) : ?><div class="alert alert-warning">The project root .env file must be writable by PHP to save settings. Keep it outside public access.</div><?php endif; ?>
    <form method="post" class="pb-4">
        <input type="hidden" name="csrf_token" value="<?php echo admin_h($csrf); ?>">
        <section class="card mb-4"><div class="card-header"><i class="fas fa-globe me-2"></i><strong>Website</strong></div><div class="card-body">
            <label for="siteBaseUrl" class="form-label">Website base URL</label>
            <input id="siteBaseUrl" class="form-control" type="url" name="SITE_BASE_URL" value="" placeholder="<?php echo admin_h((string) (getenv('SITE_BASE_URL') ?: 'https://your-domain.com')); ?>">
            <div class="form-text">Leave blank to keep the current URL. Used for payment return and webhook links.</div>
        </div></section>
        <section class="card mb-4"><div class="card-header d-flex justify-content-between align-items-center"><span><i class="fas fa-credit-card me-2"></i><strong>Razorpay</strong></span><span class="badge <?php echo $configured('RAZORPAY_KEY_ID') && $configured('RAZORPAY_KEY_SECRET') ? 'bg-success' : 'bg-secondary'; ?>"><?php echo $configured('RAZORPAY_KEY_ID') && $configured('RAZORPAY_KEY_SECRET') ? 'Configured' : 'Not configured'; ?></span></div><div class="card-body"><div class="row g-3">
            <?php foreach (['RAZORPAY_KEY_ID' => 'Key ID', 'RAZORPAY_KEY_SECRET' => 'Key secret', 'RAZORPAY_WEBHOOK_SECRET' => 'Webhook secret'] as $key => $label) : ?><div class="col-md-6"><label class="form-label" for="f-<?php echo admin_h($key); ?>"><?php echo admin_h($label); ?></label><input class="form-control" id="f-<?php echo admin_h($key); ?>" name="<?php echo admin_h($key); ?>" type="password" autocomplete="new-password" placeholder="<?php echo $configured($key) ? 'Saved — leave blank to keep' : 'Not set'; ?>"><label class="form-check mt-2"><input class="form-check-input" type="checkbox" name="clear[<?php echo admin_h($key); ?>]" value="1"><span class="form-check-label">Clear saved value</span></label></div><?php endforeach; ?>
        </div></div></section>
        <section class="card mb-4"><div class="card-header d-flex justify-content-between align-items-center"><span><i class="fas fa-building-columns me-2"></i><strong>Cashfree</strong></span><span class="badge <?php echo $configured('CASHFREE_APP_ID') && $configured('CASHFREE_SECRET_KEY') ? 'bg-success' : 'bg-secondary'; ?>"><?php echo $configured('CASHFREE_APP_ID') && $configured('CASHFREE_SECRET_KEY') ? 'Configured' : 'Not configured'; ?></span></div><div class="card-body"><div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="cashfreeMode">Environment</label><select id="cashfreeMode" class="form-select" name="CASHFREE_ENVIRONMENT"><option value="sandbox" <?php echo strtolower((string) (getenv('CASHFREE_ENVIRONMENT') ?: 'sandbox')) === 'sandbox' ? 'selected' : ''; ?>>Sandbox</option><option value="production" <?php echo strtolower((string) getenv('CASHFREE_ENVIRONMENT')) === 'production' ? 'selected' : ''; ?>>Production</option></select></div>
            <?php foreach (['CASHFREE_APP_ID' => 'App ID', 'CASHFREE_SECRET_KEY' => 'Secret key', 'CASHFREE_WEBHOOK_SECRET' => 'Webhook secret'] as $key => $label) : ?><div class="col-md-6"><label class="form-label" for="f-<?php echo admin_h($key); ?>"><?php echo admin_h($label); ?></label><input class="form-control" id="f-<?php echo admin_h($key); ?>" name="<?php echo admin_h($key); ?>" type="password" autocomplete="new-password" placeholder="<?php echo $configured($key) ? 'Saved — leave blank to keep' : 'Not set'; ?>"><label class="form-check mt-2"><input class="form-check-input" type="checkbox" name="clear[<?php echo admin_h($key); ?>]" value="1"><span class="form-check-label">Clear saved value</span></label></div><?php endforeach; ?>
        </div><p class="form-text mt-3 mb-0">Production mode uses live Cashfree endpoints. Confirm the merchant credentials and webhook configuration before switching.</p></div></section>
        <button class="btn btn-admin-primary" type="submit"><i class="fas fa-floppy-disk me-2"></i>Save payment settings</button>
    </form>
</div></main><footer class="py-4 bg-light mt-auto"><div class="container-fluid px-4"><div class="small text-muted">&copy; <?php echo date('Y'); ?> Yati Foundation</div></div></footer></div></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script><script src="js/scripts.js"></script>
</body></html>
