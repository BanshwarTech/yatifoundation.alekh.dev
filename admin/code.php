<?php
session_start();
require_once __DIR__ . '/includes/admin_helpers.php';
include_once('../Includes/db.php');

$msg = $_GET['msg'] ?? '';

if ($msg === 'logout') {
    admin_require_post();
} else {
    admin_require_auth();
    admin_require_post();
}

$uploadDir = __DIR__ . '/upload';

/** Soft-delete a row (isDel = 0) by id using a whitelisted table + id column. */
function soft_delete(mysqli $con, string $table, string $idCol, $id, string $redirect): void
{
    $id = (int) $id;
    if ($id < 1) {
        flash_redirect('Invalid record selected.', $redirect);
    }
    $stmt = mysqli_prepare($con, "UPDATE `$table` SET isDel = 0 WHERE `$idCol` = ?");
    if (!$stmt) {
        flash_redirect('Could not prepare the delete operation.', $redirect);
    }
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    flash_redirect($ok ? 'Deleted successfully.' : 'Could not delete.', $redirect);
}

function get_active_admin_record(mysqli $con, string $table, string $idColumn, int $id): ?array
{
    $stmt = mysqli_prepare($con, "SELECT * FROM `$table` WHERE `$idColumn` = ? AND isDel = 1 LIMIT 1");
    if (!$stmt) {
        return null;
    }
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $record = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt)) ?: null;
    mysqli_stmt_close($stmt);
    return $record;
}

/** Returns an empty string when no replacement was uploaded. */
function replacement_image_upload(array $file, string $directory, string $redirect): string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return '';
    }
    $uploaded = handle_image_upload($file, $directory);
    if ($uploaded === null) {
        flash_redirect('Please upload a valid image (PNG/JPG/WEBP, max 5MB).', $redirect);
    }
    return $uploaded;
}

switch ($msg) {

    case 'logout':
        $_SESSION = [];
        session_regenerate_id(true);
        flash_redirect('Logged out successfully.', '../login.php');
        break;

    case 'update-submission-status':
        $kind = $_POST['kind'] ?? '';
        $id = (int) ($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? '';
        $options = [
            'donation' => ['donate', 'dId', ['Pending', 'Received', 'Declined']],
            'volunteer' => ['vounteer', 'vId', ['Pending', 'Contacted', 'Accepted', 'Closed']],
            'contact' => ['contact', 'cId', ['New', 'In Progress', 'Replied', 'Closed']],
        ];
        if (!isset($options[$kind]) || !in_array($status, $options[$kind][2], true) || $id < 1) {
            flash_redirect('Select a valid submission status.', 'submissionstatus.php');
        }
        [$table, $idColumn] = $options[$kind];
        $stmt = mysqli_prepare($con, "UPDATE `$table` SET status = ? WHERE `$idColumn` = ? AND isDel = 1");
        mysqli_stmt_bind_param($stmt, 'si', $status, $id);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        flash_redirect($ok ? 'Submission status updated.' : 'Could not update submission status.', 'submissionstatus.php');
        break;

    case 'add-news':
        $title = trim($_POST['title'] ?? '');
        $desc  = trim($_POST['description'] ?? '');
        $file  = handle_image_upload($_FILES['file'] ?? [], $uploadDir);
        if ($file === null) {
            flash_redirect('Please upload a valid image (PNG/JPG/WEBP, max 5MB).', 'addnews.php');
        }
        $stmt = mysqli_prepare($con, "INSERT INTO news (title, file, description, isDel, addedOn) VALUES (?,?,?,1,?)");
        if (!$stmt) {
            admin_remove_uploaded_file($uploadDir, $file);
            flash_redirect('Could not prepare the news entry.', 'addnews.php');
        }
        $today = date('Y-m-d');
        mysqli_stmt_bind_param($stmt, 'ssss', $title, $file, $desc, $today);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if (!$ok) {
            admin_remove_uploaded_file($uploadDir, $file);
        }
        flash_redirect($ok ? 'News added successfully.' : 'Could not add news.', 'addnews.php');
        break;

    case 'add-Gallery':
        $items = $_POST['items'] ?? [];
        $uploads = $_FILES['items'] ?? [];
        if (!is_array($items) || count($items) < 1 || count($items) > 10) {
            flash_redirect('Add between 1 and 10 gallery photos per batch.', 'addgallery.php');
        }
        $stmt = mysqli_prepare($con, "INSERT INTO gallery (heading, image, addedOn, isDel) VALUES (?,?,?,1)");
        if (!$stmt) {
            flash_redirect('Could not prepare the gallery entries.', 'addgallery.php');
        }
        $today = date('Y-m-d');
        $savedFiles = [];
        $ok = true;
        mysqli_begin_transaction($con);
        foreach ($items as $index => $item) {
            $heading = trim($item['heading'] ?? '');
            $fileData = [
                'name' => $uploads['name'][$index]['file'] ?? '',
                'type' => $uploads['type'][$index]['file'] ?? '',
                'tmp_name' => $uploads['tmp_name'][$index]['file'] ?? '',
                'error' => $uploads['error'][$index]['file'] ?? UPLOAD_ERR_NO_FILE,
                'size' => $uploads['size'][$index]['file'] ?? 0,
            ];
            if ($heading === '') {
                $ok = false;
                break;
            }
            $file = handle_image_upload($fileData, $uploadDir);
            if ($file === null) {
                $ok = false;
                break;
            }
            $savedFiles[] = $file;
            mysqli_stmt_bind_param($stmt, 'sss', $heading, $file, $today);
            if (!mysqli_stmt_execute($stmt)) {
                $ok = false;
                break;
            }
        }
        if ($ok) {
            mysqli_commit($con);
        } else {
            mysqli_rollback($con);
            foreach ($savedFiles as $savedFile) {
                admin_remove_uploaded_file($uploadDir, $savedFile);
            }
        }
        mysqli_stmt_close($stmt);
        flash_redirect($ok ? count($savedFiles) . ' gallery photos added successfully.' : 'Please provide a heading and valid image for every photo (PNG/JPG/WEBP, max 5MB each). No photos were added.', 'addgallery.php');
        break;

    case 'add-slider':
        $title = trim($_POST['title'] ?? '');
        $quots = trim($_POST['quots'] ?? '');
        $file  = handle_image_upload($_FILES['file'] ?? [], $uploadDir);
        if ($file === null) {
            flash_redirect('Please upload a valid image (PNG/JPG/WEBP, max 5MB).', 'addslider.php');
        }
        $stmt = mysqli_prepare($con, "INSERT INTO slider (title, quots, file, addedOn, isDel) VALUES (?,?,?,?,1)");
        if (!$stmt) {
            admin_remove_uploaded_file($uploadDir, $file);
            flash_redirect('Could not prepare the slider entry.', 'addslider.php');
        }
        $today = date('Y-m-d');
        mysqli_stmt_bind_param($stmt, 'ssss', $title, $quots, $file, $today);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if (!$ok) {
            admin_remove_uploaded_file($uploadDir, $file);
        }
        flash_redirect($ok ? 'Slider added successfully.' : 'Could not add slider.', 'addslider.php');
        break;

    case 'update-news':
        $id = (int) ($_POST['id'] ?? 0);
        $record = get_active_admin_record($con, 'news', 'nId', $id);
        if (!$record) {
            flash_redirect('News item not found.', 'newsmanagement.php');
        }
        $title = trim($_POST['title'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        if ($title === '' || $desc === '') {
            flash_redirect('Please complete all required fields.', 'addnews.php?id=' . $id);
        }
        $replacement = replacement_image_upload($_FILES['file'] ?? [], $uploadDir, 'addnews.php?id=' . $id);
        $file = $replacement !== '' ? $replacement : $record['file'];
        $stmt = mysqli_prepare($con, 'UPDATE news SET title = ?, description = ?, file = ? WHERE nId = ? AND isDel = 1');
        if (!$stmt) {
            if ($replacement !== '') admin_remove_uploaded_file($uploadDir, $replacement);
            flash_redirect('Could not prepare the news update.', 'addnews.php?id=' . $id);
        }
        mysqli_stmt_bind_param($stmt, 'sssi', $title, $desc, $file, $id);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if (!$ok && $replacement !== '') admin_remove_uploaded_file($uploadDir, $replacement);
        flash_redirect($ok ? 'News updated successfully.' : 'Could not update news.', 'newsmanagement.php');
        break;

    case 'update-Gallery':
        $id = (int) ($_POST['id'] ?? 0);
        $record = get_active_admin_record($con, 'gallery', 'gId', $id);
        if (!$record) {
            flash_redirect('Gallery item not found.', 'gallerymanagement.php');
        }
        $heading = trim($_POST['heading'] ?? '');
        if ($heading === '') {
            flash_redirect('Please enter a gallery heading.', 'addgallery.php?id=' . $id);
        }
        $replacement = replacement_image_upload($_FILES['file'] ?? [], $uploadDir, 'addgallery.php?id=' . $id);
        $image = $replacement !== '' ? $replacement : $record['image'];
        $stmt = mysqli_prepare($con, 'UPDATE gallery SET heading = ?, image = ? WHERE gId = ? AND isDel = 1');
        if (!$stmt) {
            if ($replacement !== '') admin_remove_uploaded_file($uploadDir, $replacement);
            flash_redirect('Could not prepare the gallery update.', 'addgallery.php?id=' . $id);
        }
        mysqli_stmt_bind_param($stmt, 'ssi', $heading, $image, $id);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if (!$ok && $replacement !== '') admin_remove_uploaded_file($uploadDir, $replacement);
        flash_redirect($ok ? 'Gallery item updated successfully.' : 'Could not update gallery item.', 'gallerymanagement.php');
        break;

    case 'update-slider':
        $id = (int) ($_POST['id'] ?? 0);
        $record = get_active_admin_record($con, 'slider', 'sId', $id);
        if (!$record) {
            flash_redirect('Slider item not found.', 'slidermanagement.php');
        }
        $title = trim($_POST['title'] ?? '');
        $quots = trim($_POST['quots'] ?? '');
        if ($title === '' || $quots === '') {
            flash_redirect('Please complete all required fields.', 'addslider.php?id=' . $id);
        }
        $replacement = replacement_image_upload($_FILES['file'] ?? [], $uploadDir, 'addslider.php?id=' . $id);
        $file = $replacement !== '' ? $replacement : $record['file'];
        $stmt = mysqli_prepare($con, 'UPDATE slider SET title = ?, quots = ?, file = ? WHERE sId = ? AND isDel = 1');
        if (!$stmt) {
            if ($replacement !== '') admin_remove_uploaded_file($uploadDir, $replacement);
            flash_redirect('Could not prepare the slider update.', 'addslider.php?id=' . $id);
        }
        mysqli_stmt_bind_param($stmt, 'sssi', $title, $quots, $file, $id);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if (!$ok && $replacement !== '') admin_remove_uploaded_file($uploadDir, $replacement);
        flash_redirect($ok ? 'Slider updated successfully.' : 'Could not update slider.', 'slidermanagement.php');
        break;

    case 'change-password':
        $old  = $_POST['old'] ?? '';
        $new  = $_POST['new'] ?? '';
        $cnew = $_POST['cnew'] ?? '';

        $stmt = mysqli_prepare($con, "SELECT id, password FROM admin WHERE userId = ? LIMIT 1");
        if (!$stmt) {
            flash_redirect('Could not verify the admin account.', 'changepassword.php');
        }
        mysqli_stmt_bind_param($stmt, 's', $_SESSION['loginAdmin']);
        mysqli_stmt_execute($stmt);
        $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);

        if (!$row) {
            flash_redirect('Account not found.', 'changepassword.php');
        }

        // Verify current password (supports legacy plaintext too).
        $stored = $row['password'];
        $validOld = password_get_info($stored)['algo'] ? password_verify($old, $stored) : hash_equals($stored, $old);

        if (!$validOld) {
            flash_redirect('Your current password is incorrect.', 'changepassword.php');
        }
        if ($old === $new) {
            flash_redirect('New password must be different from the old one.', 'changepassword.php');
        }
        if ($new !== $cnew) {
            flash_redirect('New password and confirmation do not match.', 'changepassword.php');
        }
        if (strlen($new) < 6) {
            flash_redirect('Password must be at least 6 characters.', 'changepassword.php');
        }

        $hash = password_hash($new, PASSWORD_DEFAULT);
        $up = mysqli_prepare($con, "UPDATE admin SET password = ? WHERE id = ?");
        if (!$up) {
            flash_redirect('Could not prepare the password update.', 'changepassword.php');
        }
        mysqli_stmt_bind_param($up, 'si', $hash, $row['id']);
        $updated = mysqli_stmt_execute($up);
        mysqli_stmt_close($up);
        if ($updated) {
            $_SESSION = [];
            session_regenerate_id(true);
            flash_redirect('Password changed. Please log in again.', '../login.php');
        }
        flash_redirect('Could not change password.', 'changepassword.php');
        break;

    case 'delete-Contact':
        soft_delete($con, 'contact', 'cId', $_REQUEST['id'] ?? 0, 'contactmanagement.php');
        break;
    case 'delete-Volunteer':
        soft_delete($con, 'vounteer', 'vId', $_REQUEST['id'] ?? 0, 'volunteermanagement.php');
        break;
    case 'delete-Donate':
        soft_delete($con, 'donate', 'dId', $_REQUEST['id'] ?? 0, 'donatemanagement.php');
        break;
    case 'delete-Gallery':
        soft_delete($con, 'gallery', 'gId', $_REQUEST['id'] ?? 0, 'gallerymanagement.php');
        break;
    case 'delete-News':
        soft_delete($con, 'news', 'nId', $_REQUEST['id'] ?? 0, 'newsmanagement.php');
        break;
    case 'delete-Slider':
        soft_delete($con, 'slider', 'sId', $_REQUEST['id'] ?? 0, 'slidermanagement.php');
        break;
}
