<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <div class="admin-current-time d-none d-md-flex ms-auto me-3" aria-label="Current India date and time">
        <i class="far fa-clock" aria-hidden="true"></i>
        <span id="adminCurrentTime"><?php echo htmlspecialchars(date('D, d M Y - h:i A'), ENT_QUOTES, 'UTF-8'); ?> IST</span>
    </div>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <button class="admin-profile-toggle" id="navbarDropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Open admin account menu">
                <span class="admin-profile-avatar"><i class="fas fa-user" aria-hidden="true"></i></span>
                <i class="fas fa-chevron-down admin-profile-chevron" aria-hidden="true"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end admin-user-menu" aria-labelledby="navbarDropdown">
                <li>
                    <div class="admin-menu-user">
                        <span class="admin-menu-avatar"><i class="fas fa-user" aria-hidden="true"></i></span>
                        <span><small>Signed in as</small><strong><?php echo htmlspecialchars($_SESSION['loginAdmin'] ?? 'Admin', ENT_QUOTES, 'UTF-8'); ?></strong></span>
                    </div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="changepassword.php"><i class="fas fa-shield-halved" aria-hidden="true"></i><span>Change password</span></a></li>
                <li>
                    <form action="code.php?msg=logout" method="post" class="admin-menu-logout">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(admin_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <button class="dropdown-item" type="submit"><i class="fas fa-arrow-right-from-bracket" aria-hidden="true"></i><span>Sign out</span></button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<?php
require_once __DIR__ . '/../../Includes/toast.php';
render_app_toast();
?>
<script src="../assets/js/toast.js"></script>
<script>
    (() => {
        const clock = document.getElementById('adminCurrentTime');
        if (!clock) return;
        const formatter = new Intl.DateTimeFormat('en-IN', {
            timeZone: 'Asia/Kolkata', weekday: 'short', day: '2-digit', month: 'short',
            year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true
        });
        const updateClock = () => { clock.textContent = `${formatter.format(new Date())} IST`; };
        updateClock();
        window.setInterval(updateClock, 30000);
    })();
</script>
