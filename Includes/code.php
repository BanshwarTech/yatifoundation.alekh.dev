<?php
session_start();
include_once('db.php');
require_once __DIR__ . '/../payment/gateways.php';

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
            flash_redirect('Please enter correct email and password.', '../login.php');
        }
        break;

    /* ------------------------------------------------------------ VOLUNTEER */
    case 'add-volunteer':
        if (isset($_POST['btnVounteer'])) {
            if (!public_csrf_valid() || !empty($_POST['website'])) flash_redirect('Please refresh the page and try again.', '../volunteer.php');
            $name    = trim($_POST['name'] ?? '');
            $email   = trim($_POST['email'] ?? '');
            $mobile  = trim($_POST['mobile'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $gender  = trim($_POST['gender'] ?? '');
            if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $mobile === '' || $address === '') flash_redirect('Please complete the required fields with a valid email.', '../volunteer.php');
            $profile = isset($_FILES['profile']) ? (handle_image_upload($_FILES['profile'], __DIR__ . '/../admin/upload') ?? '') : '';

            $stmt = mysqli_prepare($con, "INSERT INTO vounteer (name, email, mobile, profile, address, addedOn, gender, isDel, status) VALUES (?,?,?,?,?,?,?,1,'Pending')");
            $today = date('Y-m-d');
            mysqli_stmt_bind_param($stmt, 'sssssss', $name, $email, $mobile, $profile, $address, $today, $gender);
            $ok = mysqli_stmt_execute($stmt);
            flash_redirect($ok ? 'Thank you! Your volunteer application was received. Our team will review it.' : 'Something went wrong. Please try again.', '../volunteer.php');
        }
        break;

    /* --------------------------------------------------------------- DONATE */
    case 'add-donate':
        if (isset($_POST['btnDonate'])) {
            if (!public_csrf_valid() || !empty($_POST['website'])) flash_redirect('Please refresh the page and try again.', '../donate.php');
            $name    = trim($_POST['name'] ?? '');
            $mobile  = trim($_POST['mobile'] ?? '');
            $email   = trim($_POST['email'] ?? '');
            $amountInput = trim((string) ($_POST['amount'] ?? ''));
            $amount  = is_numeric($amountInput) ? (float) $amountInput : 0.0;
            $purpose = trim($_POST['donation'] ?? '');
            $address = trim($_POST['address'] ?? '');
            if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $mobile === '' || !preg_match('/^\d{1,8}(?:\.\d{1,2})?$/', $amountInput) || $amount <= 0 || $amount > 10000000 || $purpose === '') flash_redirect('Please enter valid donation pledge details.', '../donate.php');
            $gateway = trim((string) ($_POST['payment_gateway'] ?? ''));
            $available = payment_available_gateways();
            if ($gateway !== '' && !isset($available[$gateway])) flash_redirect('That payment method is unavailable. Please select an active option.', '../donate.php');
            if ($gateway === 'cashfree' && !preg_match('/^\d{10,12}$/', preg_replace('/\D+/', '', $mobile))) flash_redirect('Enter a valid mobile number for Cashfree checkout.', '../donate.php');

            $stmt = mysqli_prepare($con, "INSERT INTO donate (name, mobile, email, amount, purposeofDonation, address, addedOn, isDel, status) VALUES (?,?,?,?,?,?,?,1,'Pending')");
            $today = date('Y-m-d');
            mysqli_stmt_bind_param($stmt, 'sssdsss', $name, $mobile, $email, $amount, $purpose, $address, $today);
            $ok = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            if (!$ok) flash_redirect('Something went wrong. Please try again.', '../donate.php');

            if ($gateway !== '') {
                $donationId = (int) mysqli_insert_id($con);
                $token = bin2hex(random_bytes(32));
                $internalOrderId = 'yf_' . bin2hex(random_bytes(12));
                $amountForGateway = number_format($amount, 2, '.', '');
                $payment = mysqli_prepare($con, "INSERT INTO donation_payments (donationId,paymentToken,internalOrderId,gateway,amount,currency,status,createdOn,updatedOn) VALUES (?,?,?,?,?,'INR','creating',NOW(),NOW())");
                if (!$payment) flash_redirect('Your pledge was saved, but checkout could not start. Please contact the foundation.', '../donate.php');
                mysqli_stmt_bind_param($payment, 'isssd', $donationId, $token, $internalOrderId, $gateway, $amountForGateway);
                $savedPayment = mysqli_stmt_execute($payment);
                $paymentId = (int) mysqli_insert_id($con);
                mysqli_stmt_close($payment);
                if (!$savedPayment) flash_redirect('Your pledge was saved, but checkout could not start. Please contact the foundation.', '../donate.php');

                $providerOrder = payment_create_provider_order($gateway, $internalOrderId, $donationId, $amountForGateway, $name, $email, $mobile);
                if (!$providerOrder) {
                    $failed = mysqli_prepare($con, "UPDATE donation_payments SET status='failed',updatedOn=NOW() WHERE paymentId=?");
                    mysqli_stmt_bind_param($failed, 'i', $paymentId);
                    mysqli_stmt_execute($failed);
                    mysqli_stmt_close($failed);
                    flash_redirect('Your pledge was saved, but online checkout could not be started. Please try again later or contact us.', '../donate.php');
                }
                $updatePayment = mysqli_prepare($con, "UPDATE donation_payments SET gatewayOrderId=?,gatewaySessionId=?,status='pending',updatedOn=NOW() WHERE paymentId=?");
                mysqli_stmt_bind_param($updatePayment, 'ssi', $providerOrder['order_id'], $providerOrder['session_id'], $paymentId);
                $updatedPayment = mysqli_stmt_execute($updatePayment);
                mysqli_stmt_close($updatePayment);
                if (!$updatedPayment) flash_redirect('Your pledge was saved, but checkout could not be prepared. Please contact us.', '../donate.php');
                header('Location: ../payment/checkout.php?token=' . rawurlencode($token));
                exit;
            }
            flash_redirect('Your donation pledge was recorded. Our team will confirm it after payment is verified.', '../donate.php');
        }
        break;

    /* -------------------------------------------------------------- CONTACT */
    case 'add-contact':
        if (isset($_POST['btnContact'])) {
            if (!public_csrf_valid() || !empty($_POST['website'])) flash_redirect('Please refresh the page and try again.', '../contact-us.php');
            $name    = trim($_POST['name'] ?? '');
            $email   = trim($_POST['email'] ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');
            if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $subject === '' || $message === '') flash_redirect('Please complete all fields with a valid email.', '../contact-us.php');

            $stmt = mysqli_prepare($con, "INSERT INTO contact (name, email, subject, message, addedOn, isDel, status) VALUES (?,?,?,?,?,1,'New')");
            $today = date('Y-m-d');
            mysqli_stmt_bind_param($stmt, 'sssss', $name, $email, $subject, $message, $today);
            $ok = mysqli_stmt_execute($stmt);
            flash_redirect($ok ? 'Thank you for reaching out! We will get back to you soon.' : 'Something went wrong. Please try again.', '../contact-us.php');
        }
        break;
}
