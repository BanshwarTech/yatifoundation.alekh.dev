<?php
session_start();
include_once('../Includes/db.php');

$msg = $_REQUEST['msg'] ?? '';

// Logout is allowed without an active session; everything else is admin-only.
if ($msg !== 'logout' && empty($_SESSION['loginAdmin'])) {
    header('Location: ../index.php');
    exit;
}

$uploadDir = __DIR__ . '/upload';

/** Soft-delete a row (isDel = 0) by id using a whitelisted table + id column. */
function soft_delete(mysqli $con, string $table, string $idCol, $id, string $redirect): void
{
    $id = (int) $id;
    $stmt = mysqli_prepare($con, "UPDATE `$table` SET isDel = 0 WHERE `$idCol` = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok = mysqli_stmt_execute($stmt);
    flash_redirect($ok ? 'Deleted successfully.' : 'Could not delete.', $redirect);
}

switch ($msg) {

    case 'logout':
        $_SESSION = [];
        session_destroy();
        flash_redirect('Logged out successfully.', '../index.php');
        break;

    case 'add-news':
        $title = trim($_POST['title'] ?? '');
        $desc  = trim($_POST['description'] ?? '');
        $file  = handle_image_upload($_FILES['file'] ?? [], $uploadDir);
        if ($file === null) {
            flash_redirect('Please upload a valid image (PNG/JPG/WEBP, max 5MB).', 'AddNews.php');
        }
        $stmt = mysqli_prepare($con, "INSERT INTO news (title, file, description, isDel, addedOn) VALUES (?,?,?,1,?)");
        $today = date('Y-m-d');
        mysqli_stmt_bind_param($stmt, 'ssss', $title, $file, $desc, $today);
        $ok = mysqli_stmt_execute($stmt);
        flash_redirect($ok ? 'News added successfully.' : 'Could not add news.', 'AddNews.php');
        break;

    case 'add-Gallery':
        $heading = trim($_POST['heading'] ?? '');
        $file    = handle_image_upload($_FILES['file'] ?? [], $uploadDir);
        if ($file === null) {
            flash_redirect('Please upload a valid image (PNG/JPG/WEBP, max 5MB).', 'AddGallery.php');
        }
        $stmt = mysqli_prepare($con, "INSERT INTO gallery (heading, image, addedOn, isDel) VALUES (?,?,?,1)");
        $today = date('Y-m-d');
        mysqli_stmt_bind_param($stmt, 'sss', $heading, $file, $today);
        $ok = mysqli_stmt_execute($stmt);
        flash_redirect($ok ? 'Gallery image added successfully.' : 'Could not add image.', 'AddGallery.php');
        break;

    case 'add-slider':
        $title = trim($_POST['title'] ?? '');
        $quots = trim($_POST['quots'] ?? '');
        $file  = handle_image_upload($_FILES['file'] ?? [], $uploadDir);
        if ($file === null) {
            flash_redirect('Please upload a valid image (PNG/JPG/WEBP, max 5MB).', 'AddSlider.php');
        }
        $stmt = mysqli_prepare($con, "INSERT INTO slider (title, quots, file, addedOn, isDel) VALUES (?,?,?,?,1)");
        $today = date('Y-m-d');
        mysqli_stmt_bind_param($stmt, 'ssss', $title, $quots, $file, $today);
        $ok = mysqli_stmt_execute($stmt);
        flash_redirect($ok ? 'Slider added successfully.' : 'Could not add slider.', 'AddSlider.php');
        break;

    case 'change-password':
        $old  = $_POST['old'] ?? '';
        $new  = $_POST['new'] ?? '';
        $cnew = $_POST['cnew'] ?? '';

        $stmt = mysqli_prepare($con, "SELECT id, password FROM admin WHERE userId = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $_SESSION['loginAdmin']);
        mysqli_stmt_execute($stmt);
        $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        if (!$row) {
            flash_redirect('Account not found.', 'ChangePassword.php');
        }

        // Verify current password (supports legacy plaintext too).
        $stored = $row['password'];
        $validOld = password_get_info($stored)['algo'] ? password_verify($old, $stored) : hash_equals($stored, $old);

        if (!$validOld) {
            flash_redirect('Your current password is incorrect.', 'ChangePassword.php');
        }
        if ($old === $new) {
            flash_redirect('New password must be different from the old one.', 'ChangePassword.php');
        }
        if ($new !== $cnew) {
            flash_redirect('New password and confirmation do not match.', 'ChangePassword.php');
        }
        if (strlen($new) < 6) {
            flash_redirect('Password must be at least 6 characters.', 'ChangePassword.php');
        }

        $hash = password_hash($new, PASSWORD_DEFAULT);
        $up = mysqli_prepare($con, "UPDATE admin SET password = ? WHERE id = ?");
        mysqli_stmt_bind_param($up, 'si', $hash, $row['id']);
        if (mysqli_stmt_execute($up)) {
            $_SESSION = [];
            session_destroy();
            flash_redirect('Password changed. Please log in again.', '../index.php');
        }
        flash_redirect('Could not change password.', 'ChangePassword.php');
        break;

    case 'delete-Contact':
        soft_delete($con, 'contact', 'cId', $_REQUEST['id'] ?? 0, 'ContactManagement.php');
        break;
    case 'delete-Volunteer':
        soft_delete($con, 'vounteer', 'vId', $_REQUEST['id'] ?? 0, 'VolunteerManagement.php');
        break;
    case 'delete-Donate':
        soft_delete($con, 'donate', 'dId', $_REQUEST['id'] ?? 0, 'DonateManagement.php');
        break;
    case 'delete-Gallery':
        soft_delete($con, 'gallery', 'gId', $_REQUEST['id'] ?? 0, 'GalleryManagement.php');
        break;
    case 'delete-News':
        soft_delete($con, 'news', 'nId', $_REQUEST['id'] ?? 0, 'NewsManagement.php');
        break;
    case 'delete-Slider':
        soft_delete($con, 'slider', 'sId', $_REQUEST['id'] ?? 0, 'SliderManagement.php');
        break;
}
