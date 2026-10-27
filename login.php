<?php
session_start();
if (!empty($_SESSION['loginAdmin'])) {
    header('Location: admin/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b1020">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo @filemtime(__DIR__ . '/assets/css/style.css'); ?>">
    <title>Admin Sign In | Yati Foundation</title>
</head>

<body class="login-page">
    <main class="login-layout">
        <section class="login-form-panel" aria-labelledby="loginTitle">
            <a class="login-back" href="index.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to home</a>

            <div class="login-form-wrap">
                <a class="login-mobile-brand" href="index.php">
                    <span class="login-brand-icon"><i class="fa fa-hand-holding-heart" aria-hidden="true"></i></span>
                    <span class="login-brand-copy"><span>Yati <strong>Foundation</strong></span><small>Care. Hope. Change.</small></span>
                </a>
                <div class="login-heading">
                    <span class="login-eyebrow">Admin portal</span>
                    <h1 id="loginTitle">Welcome back</h1>
                    <p>Enter your email and password to sign in.</p>
                </div>

                <form class="login-form" action="Includes/code.php?msg=login" method="post">
                    <div class="login-field">
                        <label for="loginEmail">Email address <span aria-hidden="true">*</span></label>
                        <input type="email" name="email" id="loginEmail" placeholder="admin@example.com" autocomplete="username" required autofocus>
                    </div>
                    <div class="login-field">
                        <label for="loginPassword">Password <span aria-hidden="true">*</span></label>
                        <div class="login-password-wrap">
                            <input type="password" id="loginPassword" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                            <button type="button" class="login-password-toggle" id="pwdToggle" aria-label="Show password" aria-pressed="false">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="login-submit" name="btnlogin">
                        Sign in <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </form>
                <p class="login-note"><i class="fa fa-lock" aria-hidden="true"></i> Authorized foundation administrators only</p>
            </div>
        </section>

        <aside class="login-brand-panel" aria-label="Yati Foundation admin portal">
            <div class="login-brand-content">
                <span class="login-brand-icon login-brand-icon-large"><i class="fa fa-hand-holding-heart" aria-hidden="true"></i></span>
                <p class="login-panel-kicker">YATI FOUNDATION</p>
                <p class="login-panel-slogan">Care. Hope. Change.</p>
                <h2>Care that creates<br><span>lasting change.</span></h2>
                <p class="login-panel-copy">Your work helps bring education, healthcare and opportunity closer to every community.</p>
                <ul class="login-benefits">
                    <li><span><i class="fa fa-check" aria-hidden="true"></i></span> Keep foundation stories up to date</li>
                    <li><span><i class="fa fa-check" aria-hidden="true"></i></span> Review volunteer and donor submissions</li>
                    <li><span><i class="fa fa-check" aria-hidden="true"></i></span> Manage gallery and homepage content</li>
                </ul>
            </div>
            <span class="login-panel-footer">Together, we make a difference.</span>
        </aside>
    </main>

    <button class="back-to-top" id="backToTop" type="button" aria-label="Back to top" title="Back to top">
        <i class="fa fa-arrow-up" aria-hidden="true"></i>
    </button>
    <?php
    require_once __DIR__ . '/Includes/toast.php';
    render_app_toast();
    ?>

    <script>
        (function () {
            var toggle = document.getElementById('pwdToggle');
            var password = document.getElementById('loginPassword');
            if (toggle && password) {
                toggle.addEventListener('click', function () {
                    var show = password.type === 'password';
                    password.type = show ? 'text' : 'password';
                    toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
                    toggle.setAttribute('aria-pressed', String(show));
                    toggle.innerHTML = show
                        ? '<i class="fa fa-eye-slash" aria-hidden="true"></i>'
                        : '<i class="fa fa-eye" aria-hidden="true"></i>';
                });
            }
        })();
    </script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/toast.js"></script>
</body>

</html>
