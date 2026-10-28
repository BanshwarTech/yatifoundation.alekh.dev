<?php
require_once __DIR__ . '/env.php';
/**
 * Database connection + small helpers.
 * Credentials can be overridden via environment variables for production.
 */

$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';
$DB_NAME = getenv('DB_NAME') ?: 'yatifoundation';

// Throw exceptions on mysqli errors so failures are caught, not echoed silently.
mysqli_report(MYSQLI_REPORT_OFF);

$con = mysqli_connect("localhost", "alekh_yati", "AbYv]lHP^QH8RnJ=", "alekh_yati");;
if (!$con) {
    http_response_code(500);
    exit('Service temporarily unavailable. Please try again later.');
}
mysqli_set_charset($con, 'utf8mb4');

function public_csrf_token(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (empty($_SESSION['public_csrf_token'])) $_SESSION['public_csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['public_csrf_token'];
}

function public_csrf_valid(): bool
{
    $token = $_POST['csrf_token'] ?? '';
    return is_string($token) && !empty($_SESSION['public_csrf_token']) && hash_equals($_SESSION['public_csrf_token'], $token);
}

/**
 * Show a JS alert and redirect — safe replacement for the old debug echoes.
 */
function flash_redirect(string $message, string $url): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (preg_match('/success|thank you|received|changed|recorded|updated|added|published|saved|archived/i', $message)) {
        $type = 'success';
    } elseif (preg_match('/please|must|match/i', $message)) {
        $type = 'warning';
    } else {
        $type = 'error';
    }

    $_SESSION['app_toast'] = ['message' => $message, 'type' => $type];
    header('Location: ' . $url);
    exit;
}

/**
 * Validate + move an uploaded image. Returns the stored (safe) filename or null.
 */
function handle_image_upload(array $file, string $destDir): ?string
{
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    if ($file['size'] > 5 * 1024 * 1024) { // 5 MB cap
        return null;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowed = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/jpg' => 'jpg', 'image/webp' => 'webp'];
    if (!isset($allowed[$mime])) {
        return null;
    }
    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }
    $safeName = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    if (!move_uploaded_file($file['tmp_name'], rtrim($destDir, '/') . '/' . $safeName)) {
        return null;
    }
    return $safeName;
}
