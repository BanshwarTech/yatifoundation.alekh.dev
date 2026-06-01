<?php
session_start();
include_once('Includes/db.php');
$pageTitle = 'Gallery';
$pageDesc  = 'See Yati Foundation in action — photos from our programmes, events and the communities we serve.';
include 'Includes/head.php';
?>

<section class="page-heading">
    <div class="container">
        <h1>Gallery</h1>
        <div class="breadcrumb-nav"><a href="index.php">Home</a> &nbsp;/&nbsp; Gallery</div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="section-head center reveal">
            <span class="eyebrow center">Our Work in Pictures</span>
            <h2 class="section-title">Moments That Matter</h2>
            <p class="section-lead">Every photo tells a story of hope, resilience and the difference your support
                makes.</p>
        </div>

        <div class="gallery-grid">
            <?php
            $result = mysqli_query($con, "SELECT * FROM gallery WHERE isDel='1' ORDER BY gId DESC");
            if ($result && mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_assoc($result)):
                    $img = 'admin/upload/' . rawurlencode($row['image']);
            ?>
                    <a class="gallery-card reveal" data-lightbox="<?php echo $img; ?>">
                        <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($row['heading']); ?>" loading="lazy">
                        <span class="g-zoom"><i class="fa fa-expand"></i></span>
                        <div class="g-overlay">
                            <span class="category"><?php echo htmlspecialchars($row['heading']); ?></span>
                            <h6><i class="fa fa-calendar me-1"></i><?php echo htmlspecialchars($row['addedOn']); ?></h6>
                        </div>
                    </a>
            <?php endwhile; else: ?>
                <p class="text-muted">No gallery images yet. Please check back soon.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Lightbox -->
<div id="lightbox"><img src="" alt="Gallery image"></div>

<?php include 'Includes/footer.php'; ?>
