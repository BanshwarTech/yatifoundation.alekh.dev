<?php
session_start();
include_once('Includes/db.php');
$pageTitle = 'News & Updates';
$pageDesc  = 'Latest news, stories and updates from Yati Foundation and the communities we serve.';
include 'Includes/head.php';
?>

<section class="page-heading">
    <div class="container">
        <h1>News &amp; Updates</h1>
        <div class="breadcrumb-nav"><a href="index.php">Home</a> &nbsp;/&nbsp; News</div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="section-head center reveal">
            <span class="eyebrow center">Stay Informed</span>
            <h2 class="section-title">Latest Stories &amp; Updates</h2>
            <p class="section-lead">Follow our journey, milestones and the impact your support creates on the ground.</p>
        </div>

        <div class="row g-4">
            <?php
            $result = mysqli_query($con, "SELECT * FROM news WHERE isDel='1' ORDER BY nId DESC");
            if ($result && mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_assoc($result)):
                    $img = 'admin/upload/' . rawurlencode($row['file']);
            ?>
                    <div class="col-lg-4 col-md-6 reveal">
                        <article class="news-card">
                            <div class="news-thumb">
                                <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" loading="lazy">
                            </div>
                            <div class="news-body">
                                <span class="category"><i class="fa fa-calendar me-1"></i><?php echo htmlspecialchars($row['addedOn']); ?></span>
                                <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                                <p><?php echo nl2br(htmlspecialchars(mb_strimwidth($row['description'], 0, 200, '…'))); ?></p>
                            </div>
                        </article>
                    </div>
            <?php endwhile; else: ?>
                <div class="col-12 text-center text-muted">No news articles yet. Please check back soon.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'Includes/footer.php'; ?>
