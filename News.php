<?php
session_start();
include_once('Includes/db.php');
$pageTitle = 'News & Updates';
$pageDesc  = 'Latest news, stories and updates from Yati Foundation and the communities we serve.';
$pageHeroEyebrow = 'News from the field';
$pageHeroTitle = 'Good things are';
$pageHeroHighlight = 'happening together.';
$pageHeroDescription = 'Follow our latest stories, milestones and the impact communities are creating together.';
$pageHeroAsideValue = 'Our stories';
$pageHeroAsideLabel = "Updates from\nour community";
$pageHeroAsideIcon = 'fa-book-open';
$pageHeroCurrent = 'News';
function news_summary(string $description, int $limit): string
{
    $intro = trim($description);
    if (preg_match('/\R[ \t]*##[ \t]+/u', $intro, $heading, PREG_OFFSET_CAPTURE)) {
        $intro = substr($intro, 0, $heading[0][1]);
    } elseif (preg_match('/^[ \t]*##[ \t]+/u', $intro)) {
        $intro = preg_replace('/^[ \t]*##[ \t]+/u', '', $intro);
    }
    $intro = preg_replace('/(^|\R)[ \t]*#{1,6}[ \t]*/u', '$1', $intro);
    $plain = trim(preg_replace('/\s+/u', ' ', strip_tags($intro)));
    return mb_strimwidth($plain, 0, $limit, '…');
}
include 'Includes/head.php';
include 'Includes/page-hero.php';
?>

<section class="section-pad news-page">
    <div class="container">
        <div class="row g-4">
            <?php
            $result = mysqli_query($con, "SELECT * FROM news WHERE isDel='1' ORDER BY nId DESC");
            if ($result && mysqli_num_rows($result) > 0):
                $featured = mysqli_fetch_assoc($result);
                $featuredUrl = 'newsdetail.php?id=' . (int) $featured['nId'];
                $featuredImage = 'admin/upload/' . rawurlencode($featured['file']);
            ?>
                <div class="col-12 reveal">
                    <article class="news-featured">
                        <a class="news-featured-thumb" href="<?php echo $featuredUrl; ?>">
                            <img src="<?php echo $featuredImage; ?>" alt="<?php echo htmlspecialchars($featured['title'], ENT_QUOTES, 'UTF-8'); ?>" fetchpriority="high">
                            <span class="news-featured-label"><i class="fa fa-star"></i> Latest story</span>
                        </a>
                        <div class="news-featured-body">
                            <span class="news-date"><i class="fa fa-calendar"></i><?php echo htmlspecialchars($featured['addedOn'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <h2><a href="<?php echo $featuredUrl; ?>"><?php echo htmlspecialchars($featured['title'], ENT_QUOTES, 'UTF-8'); ?></a></h2>
                            <p><?php echo htmlspecialchars(news_summary((string) $featured['description'], 320), ENT_QUOTES, 'UTF-8'); ?></p>
                            <a class="btn-brand news-featured-link" href="<?php echo $featuredUrl; ?>">Read full story <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </article>
                </div>
                <?php if (mysqli_num_rows($result) > 1): ?>
                    <div class="col-12 news-list-heading"><span class="eyebrow">More from Yati</span><h3>More stories</h3></div>
                <?php endif; ?>
                <?php while ($row = mysqli_fetch_assoc($result)):
                    $img = 'admin/upload/' . rawurlencode($row['file']);
                    $detailUrl = 'newsdetail.php?id=' . (int) $row['nId'];
                ?>
                    <div class="col-lg-4 col-md-6 reveal">
                        <article class="news-card">
                            <a class="news-thumb" href="<?php echo $detailUrl; ?>">
                                <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
                            </a>
                            <div class="news-body">
                                <span class="category"><i class="fa fa-calendar me-1"></i><?php echo htmlspecialchars($row['addedOn'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <h4><a href="<?php echo $detailUrl; ?>"><?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?></a></h4>
                                <p><?php echo htmlspecialchars(news_summary((string) $row['description'], 160), ENT_QUOTES, 'UTF-8'); ?></p>
                                <a class="news-more" href="<?php echo $detailUrl; ?>">Read More <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </article>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted">No news articles yet. Please check back soon.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'Includes/footer.php'; ?>
