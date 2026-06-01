<?php
session_start();
include_once('db.php');

$msg = $_REQUEST['msg'] ?? '';

switch ($msg) {

    /* ---------------------------------------------------------------- LOGIN */
    case 'login':
        if (isset($_POST['btnlogin'])) {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $stmt = mysqli_prepare($con, "SELECT id, userId, password, usertype FROM admin WHERE userId = ? AND isDel = 1 LIMIT 1");
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            if ($row && $row['usertype'] === 'admin') {
                $stored = $row['password'];
                $ok = false;

                // Supports bcrypt hashes and transparently upgrades legacy plaintext.
                if (password_get_info($stored)['algo']) {
                    $ok = password_verify($password, $stored);
                } elseif (hash_equals($stored, $password)) {
                    $ok = true;
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $up = mysqli_prepare($con, "UPDATE admin SET password = ? WHERE id = ?");
                    mysqli_stmt_bind_param($up, 'si', $newHash, $row['id']);
                    mysqli_stmt_execute($up);
                }

                if ($ok) {
                    session_regenerate_id(true);
                    $_SESSION['loginAdmin'] = $row['userId'];
                    header('Location: ../admin/index.php');
                    exit;
                }
            }
            flash_redirect('Please enter correct email and password.', '../index.php');
        }
        break;

    /* ------------------------------------------------------------ VOLUNTEER */
    case 'add-volunteer':
        if (isset($_POST['btnVounteer'])) {
            $name    = trim($_POST['name'] ?? '');
            $email   = trim($_POST['email'] ?? '');
            $mobile  = trim($_POST['mobile'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $gender  = trim($_POST['gender'] ?? '');
            $profile = isset($_FILES['profile']) ? (handle_image_upload($_FILES['profile'], __DIR__ . '/../admin/upload') ?? '') : '';

            $stmt = mysqli_prepare($con, "INSERT INTO vounteer (name, email, mobile, profile, address, addedOn, gender, isDel) VALUES (?,?,?,?,?,?,?,1)");
            $today = date('Y-m-d');
            mysqli_stmt_bind_param($stmt, 'sssssss', $name, $email, $mobile, $profile, $address, $today, $gender);
            $ok = mysqli_stmt_execute($stmt);
            flash_redirect($ok ? 'Thank you! Your volunteer application was received.' : 'Something went wrong. Please try again.', '../Vounteer.php');
        }
        break;

    /* --------------------------------------------------------------- DONATE */
    case 'add-donate':
        if (isset($_POST['btnDonate'])) {
            $name    = trim($_POST['name'] ?? '');
            $mobile  = trim($_POST['mobile'] ?? '');
            $email   = trim($_POST['email'] ?? '');
            $amount  = (float) ($_POST['amount'] ?? 0);
            $purpose = trim($_POST['donation'] ?? '');
            $address = trim($_POST['address'] ?? '');

            $stmt = mysqli_prepare($con, "INSERT INTO donate (name, mobile, email, amount, purposeofDonation, address, addedOn, isDel) VALUES (?,?,?,?,?,?,?,1)");
            $today = date('Y-m-d');
            mysqli_stmt_bind_param($stmt, 'sssdsss', $name, $mobile, $email, $amount, $purpose, $address, $today);
            $ok = mysqli_stmt_execute($stmt);
            flash_redirect($ok ? 'Thank you for your generous donation!' : 'Something went wrong. Please try again.', '../Donate.php');
        }
        break;

    /* -------------------------------------------------------------- CONTACT */
    case 'add-contact':
        if (isset($_POST['btnContact'])) {
            $name    = trim($_POST['name'] ?? '');
            $email   = trim($_POST['email'] ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');

            $stmt = mysqli_prepare($con, "INSERT INTO contact (name, email, subject, message, addedOn, isDel) VALUES (?,?,?,?,?,1)");
            $today = date('Y-m-d');
            mysqli_stmt_bind_param($stmt, 'sssss', $name, $email, $subject, $message, $today);
            $ok = mysqli_stmt_execute($stmt);
            flash_redirect($ok ? 'Thank you for reaching out! We will get back to you soon.' : 'Something went wrong. Please try again.', '../ContactUs.php');
        }
        break;
}
