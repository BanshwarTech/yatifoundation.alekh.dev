<?php
date_default_timezone_set('Asia/Kolkata');

function admin_require_auth(): void
{
    // Let search crawlers read the noindex directive; admin pages stay out of results.
    header('X-Robots-Tag: noindex, nofollow, noarchive', true);

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION['loginAdmin'])) {
        header('Location: ../login.php');
        exit;
    }
}

function admin_csrf_token(): string
{
    if (empty($_SESSION['admin_csrf_token'])) {
        $_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['admin_csrf_token'];
}

function admin_h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function admin_require_post(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        http_response_code(405);
        header('Allow: POST');
        exit('This action must be submitted using the form.');
    }

    admin_verify_csrf();
}

function admin_remove_uploaded_file(string $directory, string $filename): void
{
    $path = $directory . DIRECTORY_SEPARATOR . $filename;
    if (is_file($path) && !unlink($path)) {
        error_log('Could not remove uploaded file after its database insert failed: ' . $path);
    }
}

function admin_verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || empty($_SESSION['admin_csrf_token']) || !hash_equals($_SESSION['admin_csrf_token'], $token)) {
        http_response_code(400);
        exit('Invalid or expired form submission. Refresh the page and try again.');
    }
}
