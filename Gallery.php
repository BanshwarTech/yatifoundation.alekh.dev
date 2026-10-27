<?php
session_start();
include_once('Includes/db.php');

$galleryRows = [];
$galleryResult = mysqli_query($con, "SELECT gId, heading, image, addedOn FROM gallery WHERE isDel='1' ORDER BY gId DESC");
if ($galleryResult) {
    while ($galleryRow = mysqli_fetch_assoc($galleryResult)) {
        $galleryRows[] = $galleryRow;
    }
}

$pageTitle = 'Gallery';
$pageDesc  = 'See Yati Foundation in action through moments from our programmes, events and communities.';
$pageHeroEyebrow = 'Our work in pictures';
$pageHeroTitle = 'Stories of care,';
$pageHeroHighlight = 'captured together.';
$pageHeroDescription = 'Step into the moments, people and shared effort behind our community work.';
$pageHeroAsideValue = str_pad((string) count($galleryRows), 2, '0', STR_PAD_LEFT);
$pageHeroAsideLabel = "moments\nin the gallery";
$pageHeroAsideIcon = 'fa-camera';
$pageHeroCurrent = 'Gallery';
include 'Includes/head.php';
include 'Includes/page-hero.php';
?>

<section class="section-pad gallery-page-section">
    <div class="container">
        <div class="gallery-grid">
            <?php if ($galleryRows): foreach ($galleryRows as $row):
                $img = 'admin/upload/' . rawurlencode($row['image']);
                $safeImg = htmlspecialchars($img, ENT_QUOTES, 'UTF-8');
                $heading = htmlspecialchars($row['heading'], ENT_QUOTES, 'UTF-8');
            ?>
                <a class="gallery-card reveal" href="<?php echo $safeImg; ?>" data-lightbox="<?php echo $safeImg; ?>" aria-label="View <?php echo $heading; ?>">
                    <img src="<?php echo $safeImg; ?>" alt="<?php echo $heading; ?>" loading="lazy">
                    <span class="g-zoom" aria-hidden="true"><i class="fa fa-expand"></i></span>
                    <div class="g-overlay"><span class="gallery-photo-date"><i class="fa fa-calendar-days" aria-hidden="true"></i><?php echo htmlspecialchars($row['addedOn'], ENT_QUOTES, 'UTF-8'); ?></span><h3><?php echo $heading; ?></h3></div>
                </a>
            <?php endforeach; else: ?>
                <div class="gallery-empty"><span><i class="fa fa-images" aria-hidden="true"></i></span><h3>New moments are on their way</h3><p>There are no photos in the gallery yet. Please check back soon.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Lightbox -->
<div id="lightbox"><img src="" alt="Gallery image"></div>

<?php include 'Includes/footer.php'; ?>
