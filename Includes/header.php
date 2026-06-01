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
            <a class="btn-brand in-menu d-sm-none" href="Donate.php"><i class="fa fa-heart"></i> Donate</a>
        </nav>

        <div class="nav-cta">
            <a class="btn-brand d-none d-sm-inline-flex" href="Donate.php"><i class="fa fa-heart"></i> Donate</a>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle menu" aria-expanded="false">
                <i class="fa fa-bars"></i>
            </button>
        </div>
    </div>
</header>
