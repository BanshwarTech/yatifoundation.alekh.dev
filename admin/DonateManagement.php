<?php
require_once __DIR__ . '/includes/admin_helpers.php';
admin_require_auth();
include_once('../Includes/db.php');
?>

<!DOCTYPE html>
<html lang="en">

<?php $adminPageTitle = 'Donation Management'; include __DIR__ . '/includes/head.php'; ?>

<body class="sb-nav-fixed">
    <?php include('../admin/includes/topheader.php') ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include('../admin/includes/sidebar.php') ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="admin-page-heading admin-section-heading mt-4"><div><span class="admin-eyebrow">Yati Foundation</span><h1>Donate Management</h1><p>Review donations and donor information.</p></div></div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Donate
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Mobile Number</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Purpose of Donation</th>
                                        <th>Address</th>
                                        <th>AddedOn</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Mobile Number</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Purpose of Donation</th>
                                        <th>Address</th>
                                        <th>AddedOn</th>
                                        <th>Delete</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php

                                    $i = 1;
                                    $count = 0;
                                    $select = "select * from donate where isDel='1'";
                                    // echo $select;
                                    $result = mysqli_query($con, $select);
                                    if ($result) {
                                        while ($row = mysqli_fetch_array($result)) {
                                            $count++;
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i++; ?>
                                                </td>
                                                <td>
                                                    <?php echo admin_h($row['name']); ?>
                                                </td>
                                                <td>
                                                    <?php echo admin_h($row['mobile']); ?>
                                                </td>
                                                <td>
                                                    <?php echo admin_h($row['email']); ?>
                                                </td>
                                                <td>
                                                    <?php echo admin_h($row['amount']); ?>
                                                </td>
                                                <td>
                                                    <?php echo nl2br(admin_h($row['purposeofDonation'])); ?>
                                                </td>
                                                <td>
                                                    <?php echo nl2br(admin_h($row['address'])); ?>
                                                </td>
                                                <td>
                                                    <?php echo admin_h($row['addedOn']); ?>
                                                </td>
                                                <td>
                                                    <form action="code.php?msg=delete-Donate" method="post">
                                                        <input type="hidden" name="csrf_token" value="<?php echo admin_h(admin_csrf_token()); ?>">
                                                        <input type="hidden" name="id" value="<?php echo (int) $row['dId']; ?>">
                                                        <button type="submit" class="btn btn-link p-0" aria-label="Delete donation">
                                                            <img src="delete-button-svgrepo-com (1).svg" alt="" height="32">
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                            <?php
                                        }
                                    } ?>

                                </tbody>
                            </table>
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