<?php
require_once __DIR__ . '/includes/admin_helpers.php';
admin_require_auth();
include_once('../Includes/db.php');

$editId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$isEditing = $editId !== null && $editId !== false && $editId > 0;
$record = null;
if ($isEditing) {
    $stmt = mysqli_prepare($con, 'SELECT gId, heading, image FROM gallery WHERE gId = ? AND isDel = 1 LIMIT 1');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $editId);
        mysqli_stmt_execute($stmt);
        $record = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);
    }
    if (!$record) {
        header('Location: gallerymanagement.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php $adminPageTitle = $isEditing ? 'Edit Gallery' : 'Add Gallery'; include __DIR__ . '/includes/head.php'; ?>

<body class="sb-nav-fixed">
    <?php include('../admin/includes/topheader.php') ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include('../admin/includes/sidebar.php') ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="admin-page-heading admin-section-heading mt-4"><div><span class="admin-eyebrow">Yati Foundation</span><h1><?php echo $isEditing ? 'Edit Gallery' : 'Add Gallery'; ?></h1><p><?php echo $isEditing ? 'Update this gallery item.' : 'Upload and caption up to 10 gallery photos at once.'; ?></p></div></div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            <?php echo $isEditing ? 'Gallery details' : 'Gallery'; ?>
                        </div>
                        <div class="card-body">
                            <form class="admin-standard-grid" action="../admin/code.php?msg=<?php echo $isEditing ? 'update-Gallery' : 'add-Gallery'; ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(admin_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                <?php if ($isEditing): ?><input type="hidden" name="id" value="<?php echo (int) $record['gId']; ?>"><?php endif; ?>
                                <?php if ($isEditing): ?>
                                    <div class="mb-3">
                                        <label class="form-label" for="galleryHeading">Heading</label>
                                        <input type="text" class="form-control" id="galleryHeading" name="heading" value="<?php echo admin_h($record['heading']); ?>" required>
                                    </div>
                                    <div class="mb-3"><label class="form-label">Current image</label><div><img class="admin-edit-preview" src="upload/<?php echo rawurlencode($record['image']); ?>" alt="<?php echo admin_h($record['heading']); ?>"></div></div>
                                    <div class="admin-form-hint mb-2">Leave the replacement image empty to keep the current image.</div>
                                    <div class="mb-3">
                                        <label class="form-label" for="galleryFile">Replace image (optional)</label>
                                        <input type="file" class="form-control" id="galleryFile" name="file" accept="image/png,image/jpeg,image/webp">
                                    </div>
                                <?php else: ?>
                                    <p class="admin-form-hint mb-3">Add up to 10 photos in one batch. Each photo gets its own heading and image.</p>
                                    <div id="galleryUploadList" class="gallery-upload-list">
                                        <div class="gallery-upload-row">
                                            <div class="gallery-upload-heading"><label class="form-label" for="galleryHeading0">Photo 1 heading</label><input type="text" class="form-control" id="galleryHeading0" name="items[0][heading]" maxlength="250" required></div>
                                            <div class="gallery-upload-file"><label class="form-label" for="galleryFile0">Photo 1 image</label><input type="file" class="form-control" id="galleryFile0" name="items[0][file]" accept="image/png,image/jpeg,image/webp" required></div>
                                            <button type="button" class="gallery-upload-remove" aria-label="Remove photo" hidden><i class="fas fa-times" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                    <div class="gallery-upload-footer"><button type="button" class="btn btn-admin-secondary" id="addGalleryPhoto"><i class="fas fa-plus me-2" aria-hidden="true"></i>Add another photo</button><span id="galleryPhotoCount" class="admin-form-hint">1 / 10 photos</span></div>
                                <?php endif; ?>
                                <div class="admin-form-actions"><button type="submit" class="btn btn-primary"><?php echo $isEditing ? 'Save changes' : 'Submit'; ?></button><?php if ($isEditing): ?><a class="btn btn-admin-secondary" href="gallerymanagement.php">Cancel</a><?php endif; ?></div>
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
    <?php if (!$isEditing): ?>
    <script>
        (function () {
            const list = document.getElementById('galleryUploadList');
            const addButton = document.getElementById('addGalleryPhoto');
            const count = document.getElementById('galleryPhotoCount');
            if (!list || !addButton || !count) return;
            const limit = 10;
            const updateRows = () => {
                const rows = Array.from(list.querySelectorAll('.gallery-upload-row'));
                rows.forEach((row, index) => {
                    row.querySelector('.form-label').textContent = 'Photo ' + (index + 1) + ' heading';
                    row.querySelector('.gallery-upload-heading label').htmlFor = 'galleryHeading' + index;
                    row.querySelector('.gallery-upload-heading input').id = 'galleryHeading' + index;
                    row.querySelector('.gallery-upload-heading input').name = 'items[' + index + '][heading]';
                    row.querySelector('.gallery-upload-file label').textContent = 'Photo ' + (index + 1) + ' image';
                    row.querySelector('.gallery-upload-file label').htmlFor = 'galleryFile' + index;
                    row.querySelector('.gallery-upload-file input').id = 'galleryFile' + index;
                    row.querySelector('.gallery-upload-file input').name = 'items[' + index + '][file]';
                    row.querySelector('.gallery-upload-remove').hidden = rows.length === 1;
                });
                count.textContent = rows.length + ' / ' + limit + ' photos';
                addButton.disabled = rows.length >= limit;
            };
            addButton.addEventListener('click', () => {
                if (list.querySelectorAll('.gallery-upload-row').length >= limit) return;
                const row = list.querySelector('.gallery-upload-row').cloneNode(true);
                row.querySelectorAll('input').forEach(input => { input.value = ''; });
                list.appendChild(row);
                updateRows();
            });
            list.addEventListener('click', event => {
                const removeButton = event.target.closest('.gallery-upload-remove');
                if (!removeButton || list.querySelectorAll('.gallery-upload-row').length <= 1) return;
                removeButton.closest('.gallery-upload-row').remove();
                updateRows();
            });
            updateRows();
        })();
    </script>
    <?php endif; ?>
</body>

</html>
