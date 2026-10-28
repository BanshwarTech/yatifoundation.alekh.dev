<?php
require_once __DIR__ . '/includes/admin_helpers.php';
admin_require_auth();
include_once('../Includes/db.php');
?>

<!DOCTYPE html>
<html lang="en">

<?php $adminPageTitle = 'Change Password'; include __DIR__ . '/includes/head.php'; ?>

<body class="sb-nav-fixed">
    <?php include('../admin/includes/topheader.php') ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include('../admin/includes/sidebar.php') ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="admin-page-heading admin-section-heading mt-4"><div><span class="admin-eyebrow">Yati Foundation</span><h1>Change Password</h1><p>Keep your administrator account secure.</p></div></div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Change Password
                        </div>
                        <div class="card-body">
                            <form class="admin-standard-grid" action="../admin/code.php?msg=change-password" method="post">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(admin_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="mb-3">
                                    <label for="old" class="form-label">Old Password</label>
                                    <input type="password" class="form-control" id="old" name="old" autocomplete="current-password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new" name="new" autocomplete="new-password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cnew" class="form-label">Confirm New Password</label>
                                    <input type="password" name="cnew" id="cnew" class="form-control" autocomplete="new-password" required />
                                </div>
                                <div class="admin-form-actions"><button type="submit" class="btn btn-primary" name="btnChangePassword">Update Password</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; <?php echo date('Y'); ?> Yati Foundation</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>
