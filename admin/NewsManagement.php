<?php
require_once __DIR__ . '/includes/admin_helpers.php';
admin_require_auth();
include_once('../Includes/db.php');
?>

<!DOCTYPE html>
<html lang="en">

<?php $adminPageTitle = 'News Management'; include __DIR__ . '/includes/head.php'; ?>

<body class="sb-nav-fixed">
    <?php include('../admin/includes/topheader.php') ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include('../admin/includes/sidebar.php') ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="admin-page-heading admin-section-heading mt-4"><div><span class="admin-eyebrow">Yati Foundation</span><h1>News Management</h1><p>Manage stories and foundation updates.</p></div></div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            News
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>News Title</th>
                                        <th>File</th>
                                        <th>Description</th>
                                        <th>Added On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>News Title</th>
                                        <th>File</th>
                                        <th>Description</th>
                                        <th>Added On</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php

                                    $i = 1;
                                    $count = 0;
                                    $select = "select * from  news where isDel='1'";
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
                                                    <?php echo admin_h($row['title']); ?>
                                                </td>
                                                <td><img src="upload/<?php echo rawurlencode($row['file']); ?>" alt="<?php echo admin_h($row['title']); ?>"
                                                        height="30"></td>
                                                <td>
                                                    <?php
                                                    $descriptionPreview = preg_replace('/^##\s*/m', '', (string) $row['description']);
                                                    $descriptionPreview = trim(preg_replace('/\s+/u', ' ', $descriptionPreview));
                                                    echo '<span class="admin-table-description">' . admin_h(mb_strimwidth($descriptionPreview, 0, 150, '…')) . '</span>';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo admin_h($row['addedOn']); ?>
                                                </td>
                                                <td>
                                                    <div class="admin-table-actions">
                                                    <a class="admin-table-edit" href="addnews.php?id=<?php echo (int) $row['nId']; ?>" aria-label="Edit news"><i class="fas fa-pen-to-square" aria-hidden="true"></i></a>
                                                    <form action="code.php?msg=delete-News" method="post">
                                                        <input type="hidden" name="csrf_token" value="<?php echo admin_h(admin_csrf_token()); ?>">
                                                        <input type="hidden" name="id" value="<?php echo (int) $row['nId']; ?>">
                                                        <button type="submit" class="btn btn-link p-0" aria-label="Delete news">
                                                            <img src="delete-button-svgrepo-com (1).svg" alt="" height="20">
                                                        </button>
                                                    </form>
                                                    </div>
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
