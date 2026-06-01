<?php
/** Modern responsive header / navbar */
$current = basename($_SERVER['PHP_SELF']);
$nav = [
    'index.php'     => 'Home',
    'AboutUs.php'   => 'About Us',
    'Vounteer.php'  => 'Volunteer',
    'Gallery.php'   => 'Gallery',
    'News.php'      => 'News',
    'ContactUs.php' => 'Contact',
];
?>
<header class="site-header" id="siteHeader">
    <div class="container d-flex align-items-center justify-content-between">

        <a class="navbar-brand-yati" href="index.php">
            <span class="brand-mark"><i class="fa fa-hands-helping"></i></span>
            <span>Yati<b>Foundation</b></span>
        </a>

        <nav class="main-nav" id="mainNav">
            <?php foreach ($nav as $href => $label): ?>
                <a class="nav-link <?php echo $current === $href ? 'active' : ''; ?>" href="<?php echo $href; ?>"><?php echo $label; ?></a>
            <?php endforeach; ?>
            <button type="button" class="btn-login in-menu" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="fa fa-lock me-2"></i>Admin Login
            </button>
        </nav>

        <div class="nav-cta">
            <a class="btn-brand d-none d-sm-inline-flex" href="Donate.php"><i class="fa fa-heart"></i> Donate</a>
            <button type="button" class="btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="fa fa-lock me-2"></i>Login
            </button>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle menu" aria-expanded="false">
                <i class="fa fa-bars"></i>
            </button>
        </div>
    </div>
</header>

<!-- Admin Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Admin Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="Includes/code.php?msg=login" method="post" id="contact-form">
                    <fieldset>
                        <label for="loginEmail">Email address</label>
                        <input type="email" name="email" id="loginEmail" placeholder="admin@example.com" required>
                    </fieldset>
                    <fieldset>
                        <label for="loginPassword">Password</label>
                        <input type="password" id="loginPassword" name="password" placeholder="••••••••" required>
                    </fieldset>
                    <button type="submit" class="orange-button w-100" name="btnlogin">Sign In</button>
                </form>
            </div>
        </div>
    </div>
</div>
