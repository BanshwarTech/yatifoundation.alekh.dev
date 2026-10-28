<?php
require_once __DIR__ . '/includes/admin_helpers.php';
admin_require_auth();
include_once('../Includes/db.php');

$editId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$isEditing = $editId !== null && $editId !== false && $editId > 0;
$record = null;
if ($isEditing) {
    $stmt = mysqli_prepare($con, 'SELECT nId, title, file, description FROM news WHERE nId = ? AND isDel = 1 LIMIT 1');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $editId);
        mysqli_stmt_execute($stmt);
        $record = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);
    }
    if (!$record) {
        header('Location: newsmanagement.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php $adminPageTitle = $isEditing ? 'Edit News' : 'Add News'; include __DIR__ . '/includes/head.php'; ?>

<body class="sb-nav-fixed">
    <?php include('../admin/includes/topheader.php') ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include('../admin/includes/sidebar.php') ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="admin-page-heading admin-section-heading mt-4">
                        <div><span class="admin-eyebrow">Yati Foundation</span>
                            <h1><?php echo $isEditing ? 'Edit News' : 'Add News'; ?></h1>
                            <p><?php echo $isEditing ? 'Update this story and its image.' : 'Share a new update with your community.'; ?></p>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            <?php echo $isEditing ? 'News details' : 'News'; ?>
                        </div>
                        <div class="card-body">
                            <form class="admin-standard-grid" action="../admin/code.php?msg=<?php echo $isEditing ? 'update-news' : 'add-news'; ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token"
                                    value="<?php echo htmlspecialchars(admin_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                <?php if ($isEditing): ?><input type="hidden" name="id" value="<?php echo (int) $record['nId']; ?>"><?php endif; ?>
                                <div class="mb-3">
                                    <label for="exampleInputTitle" class="form-label">News Title</label>
                                    <input type="text" class="form-control" id="exampleInputTitle" name="title"
                                        value="<?php echo $isEditing ? admin_h($record['title']) : ''; ?>" required>
                                </div>
                                <?php if ($isEditing): ?>
                                    <div class="mb-3"><label class="form-label">Current image</label><div><img class="admin-edit-preview" src="upload/<?php echo rawurlencode($record['file']); ?>" alt="<?php echo admin_h($record['title']); ?>"></div></div>
                                    <div class="admin-form-hint mb-2">Leave the replacement image empty to keep the current image.</div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label for="exampleInputFile" class="form-label"><?php echo $isEditing ? 'Replace Image (optional)' : 'Select File'; ?></label>
                                    <input type="file" class="form-control" id="exampleInputFile" name="file"
                                        accept="image/png,image/jpeg,image/webp" <?php echo $isEditing ? '' : 'required'; ?>>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputDesc" class="form-label">Description</label>
                                    <textarea name="description" id="exampleInputDesc" class="form-control"
                                        required><?php echo $isEditing ? admin_h($record['description']) : ''; ?></textarea>
                                    <div class="admin-form-hint mt-2">For section headings, start a line with <code>##</code> (for example, <code>## Community impact</code>).</div>
                                </div>
                                <div class="admin-form-actions"><button type="submit" class="btn btn-primary"><?php echo $isEditing ? 'Save changes' : 'Submit'; ?></button><?php if ($isEditing): ?><a class="btn btn-admin-secondary" href="newsmanagement.php">Cancel</a><?php endif; ?></div>
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
