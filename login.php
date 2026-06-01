<?php
session_start();
// Already logged in? Go straight to the dashboard.
if (!empty($_SESSION['loginAdmin'])) {
    header('Location: admin/index.php');
    exit;
}
$pageTitle = 'Admin Login';
$pageDesc  = 'Secure admin login for Yati Foundation.';
include 'Includes/head.php';
?>

<section class="auth-section">
    <div class="container">
        <div class="auth-card reveal">
            <div class="auth-head">
                <span class="brand-mark"><i class="fa fa-lock"></i></span>
                <h1>Admin Login</h1>
                <p>Sign in to manage sliders, news, gallery and more.</p>
            </div>
            <form action="Includes/code.php?msg=login" method="post" id="contact-form">
                <fieldset>
                    <label for="loginEmail">Email address</label>
                    <input type="email" name="email" id="loginEmail" placeholder="admin@example.com" required autofocus>
                </fieldset>
                <fieldset>
                    <label for="loginPassword">Password</label>
                    <div class="pwd-wrap">
                        <input type="password" id="loginPassword" name="password" placeholder="••••••••" required>
                        <button type="button" class="pwd-toggle" id="pwdToggle" aria-label="Show password">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </fieldset>
                <button type="submit" class="orange-button w-100" name="btnlogin">
                    <i class="fa fa-right-to-bracket"></i> Sign In
                </button>
            </form>
            <a class="auth-back" href="index.php"><i class="fa fa-arrow-left me-1"></i> Back to website</a>
        </div>
    </div>
</section>

<script>
    (function () {
        var t = document.getElementById('pwdToggle'),
            p = document.getElementById('loginPassword');
        if (t && p) {
            t.addEventListener('click', function () {
                var show = p.type === 'password';
                p.type = show ? 'text' : 'password';
                t.innerHTML = show ? '<i class="fa fa-eye-slash"></i>' : '<i class="fa fa-eye"></i>';
            });
        }
    })();
</script>

<?php include 'Includes/footer.php'; ?>
