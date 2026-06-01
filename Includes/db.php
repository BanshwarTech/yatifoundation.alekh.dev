<?php
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

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$con) {
    http_response_code(500);
    exit('Service temporarily unavailable. Please try again later.');
}
mysqli_set_charset($con, 'utf8mb4');

/**
 * Show a JS alert and redirect — safe replacement for the old debug echoes.
 */
function flash_redirect(string $message, string $url): void
{
    $msg = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    $loc = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    echo "<script>alert(" . json_encode($msg) . ");window.location.href=" . json_encode($loc) . ";</script>";
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
