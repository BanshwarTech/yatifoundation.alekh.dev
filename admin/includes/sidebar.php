<?php
$adminCurrentPage = basename($_SERVER['PHP_SELF'] ?? '');
$adminNavLink = static function (string $href, string $icon, string $label) use ($adminCurrentPage): string {
    $active = $adminCurrentPage === $href;
    return '<a class="nav-link' . ($active ? ' active' : '') . '" href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '"' . ($active ? ' aria-current="page"' : '') . '>'
        . '<span class="sb-nav-link-icon"><i class="' . htmlspecialchars($icon, ENT_QUOTES, 'UTF-8') . '" aria-hidden="true"></i></span>'
        . '<span class="admin-nav-label">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</span>'
        . ($active ? '<span class="admin-nav-current" aria-hidden="true"></span>' : '') . '</a>';
};
?>
<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" aria-label="Admin navigation">
    <a class="admin-sidebar-brand" href="index.php" aria-label="Yati Foundation admin home">
        <span class="admin-brand-mark"><i class="fas fa-hand-holding-heart" aria-hidden="true"></i></span>
        <span><strong>Yati Foundation</strong><small>Care. Hope. Change.</small></span>
    </a>
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">OVERVIEW</div>
            <?php echo $adminNavLink('index.php', 'fas fa-house', 'Dashboard'); ?>

            <div class="sb-sidenav-menu-heading">COMMUNITY</div>
            <?php echo $adminNavLink('volunteermanagement.php', 'fas fa-people-group', 'Volunteers'); ?>
            <?php echo $adminNavLink('donatemanagement.php', 'fas fa-hand-holding-heart', 'Donations'); ?>
            <?php echo $adminNavLink('contactmanagement.php', 'fas fa-envelope', 'Messages'); ?>
            <?php echo $adminNavLink('foundationcontent.php', 'fas fa-list-check', 'Foundation content'); ?>
            <?php echo $adminNavLink('submissionstatus.php', 'fas fa-inbox', 'Submission follow-up'); ?>
            <?php echo $adminNavLink('paymentsettings.php', 'fas fa-credit-card', 'Payment settings'); ?>

            <div class="sb-sidenav-menu-heading">WEBSITE CONTENT</div>
            <?php echo $adminNavLink('newsmanagement.php', 'fas fa-newspaper', 'News library'); ?>
            <?php echo $adminNavLink('gallerymanagement.php', 'fas fa-images', 'Gallery'); ?>
            <?php echo $adminNavLink('slidermanagement.php', 'fas fa-photo-film', 'Homepage sliders'); ?>

            <div class="sb-sidenav-menu-heading">ACCOUNT</div>
            <?php echo $adminNavLink('changepassword.php', 'fas fa-shield-halved', 'Change password'); ?>
            <form action="code.php?msg=logout" method="post" class="admin-logout-form">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(admin_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" class="nav-link">
                    <span class="sb-nav-link-icon"><i class="fas fa-arrow-right-from-bracket" aria-hidden="true"></i></span>
                    <span class="admin-nav-label">Sign out</span>
                </button>
            </form>
        </div>
    </div>
    <div class="sb-sidenav-footer admin-sidebar-user">
        <span class="admin-user-avatar"><i class="fas fa-user" aria-hidden="true"></i></span>
        <span><small>Signed in as</small><strong><?php echo htmlspecialchars($_SESSION['loginAdmin'] ?? 'Admin', ENT_QUOTES, 'UTF-8'); ?></strong></span>
        <span class="admin-online-dot" title="Signed in"></span>
    </div>
</nav>
