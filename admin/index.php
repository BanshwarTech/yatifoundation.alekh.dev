<?php
require_once __DIR__ . '/includes/admin_helpers.php';
admin_require_auth();
include_once('../Includes/db.php');
?>
<!DOCTYPE html>
<html lang="en">

<?php $adminPageTitle = 'Dashboard'; include __DIR__ . '/includes/head.php'; ?>

<body class="sb-nav-fixed">
    <?php include('../admin/includes/topheader.php') ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include('../admin/includes/sidebar.php') ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="admin-page-heading mt-4">
                        <div>
                            <span class="admin-eyebrow">Yati Foundation</span>
                            <h1>Dashboard</h1>
                            <p>Manage your foundation’s content and community activity.</p>
                        </div>
                        <a class="btn btn-admin-primary" href="volunteermanagement.php"><i class="fas fa-users me-2"></i>View volunteers</a>
                    </div>
                    <div class="admin-dashboard-grid row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card admin-dashboard-card mb-4">
                                <div class="card-body"><span class="admin-dashboard-icon"><i class="fas fa-people-group"></i></span><span class="admin-dashboard-copy"><strong>Volunteer Management</strong><small>People supporting your mission</small></span></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="volunteermanagement.php">View
                                        Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card admin-dashboard-card mb-4">
                                <div class="card-body"><span class="admin-dashboard-icon"><i class="fas fa-hand-holding-heart"></i></span><span class="admin-dashboard-copy"><strong>Donation Management</strong><small>Review community contributions</small></span></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="donatemanagement.php">View
                                        Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card admin-dashboard-card mb-4">
                                <div class="card-body"><span class="admin-dashboard-icon"><i class="fas fa-envelope"></i></span><span class="admin-dashboard-copy"><strong>Contact Management</strong><small>Read incoming messages</small></span></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="contactmanagement.php">View
                                        Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card admin-dashboard-card mb-4">
                                <div class="card-body"><span class="admin-dashboard-icon"><i class="fas fa-pen-to-square"></i></span><span class="admin-dashboard-copy"><strong>Publish News</strong><small>Share the latest foundation updates</small></span></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="addnews.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card admin-dashboard-card mb-4">
                                <div class="card-body"><span class="admin-dashboard-icon"><i class="fas fa-newspaper"></i></span><span class="admin-dashboard-copy"><strong>News Management</strong><small>Edit and organize news articles</small></span></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="newsmanagement.php">View
                                        Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card admin-dashboard-card mb-4">
                                <div class="card-body"><span class="admin-dashboard-icon"><i class="fas fa-shield-halved"></i></span><span class="admin-dashboard-copy"><strong>Account Security</strong><small>Update your admin password</small></span></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="changepassword.php">View
                                        Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card admin-dashboard-card mb-4">
                                <div class="card-body"><span class="admin-dashboard-icon"><i class="fas fa-image"></i></span><span class="admin-dashboard-copy"><strong>Add Gallery Image</strong><small>Upload a new foundation photo</small></span></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="addgallery.php">Add Image</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card admin-dashboard-card mb-4">
                                <div class="card-body"><span class="admin-dashboard-icon"><i class="fas fa-images"></i></span><span class="admin-dashboard-copy"><strong>Gallery Management</strong><small>Manage published photos</small></span></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="gallerymanagement.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card admin-dashboard-card mb-4">
                                <div class="card-body"><span class="admin-dashboard-icon"><i class="fas fa-panorama"></i></span><span class="admin-dashboard-copy"><strong>Add Homepage Slider</strong><small>Feature a new homepage story</small></span></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="addslider.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card admin-dashboard-card mb-4">
                                <div class="card-body"><span class="admin-dashboard-icon"><i class="fas fa-photo-film"></i></span><span class="admin-dashboard-copy"><strong>Slider Management</strong><small>Organize homepage slides</small></span></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-dark stretched-link" href="slidermanagement.php">View
                                        Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>
