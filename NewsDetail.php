<?php
session_start();
include_once('Includes/db.php');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Fetch the requested article.
$stmt = mysqli_prepare($con, "SELECT * FROM news WHERE nId = ? AND isDel = '1' LIMIT 1");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$article = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

// Unknown / deleted article → back to the news list.
if (!$article) {
    header('Location: News.php');
    exit;
}

// A few other recent articles for the sidebar.
$recent = mysqli_query($con, "SELECT nId, title, file, addedOn FROM news WHERE isDel = '1' AND nId <> " . $id . " ORDER BY nId DESC LIMIT 4");

$pageTitle = $article['title'];
$pageDesc  = mb_strimwidth(strip_tags($article['description']), 0, 150, '…');
include 'Includes/head.php';
?>

<section class="page-heading">
    <div class="container">
        <h1><?php echo htmlspecialchars($article['title']); ?></h1>
        <div class="breadcrumb-nav"><a href="index.php">Home</a> &nbsp;/&nbsp; <a href="News.php">News</a> &nbsp;/&nbsp; Article</div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-5">
            <!-- Article -->
            <div class="col-lg-8 reveal">
                <article class="article">
                    <h2 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h2>
                    <div class="article-meta">
                        <span><i class="fa fa-calendar me-1"></i><?php echo htmlspecialchars($article['addedOn']); ?></span>
                        <span><i class="fa fa-folder me-1"></i>News &amp; Updates</span>
                    </div>
                    <div class="article-img">
                        <img src="admin/upload/<?php echo rawurlencode($article['file']); ?>"
                            alt="<?php echo htmlspecialchars($article['title']); ?>">
                    </div>
                    <div class="article-body">
                        <?php
                        $body = trim($article['description']);
                        if ($body !== '') {
                            echo nl2br(htmlspecialchars($body));
                        } else {
                            echo '<p>' . htmlspecialchars($article['title']) . '</p>';
                            echo '<p class="text-muted">Full details for this story are coming soon. Stay tuned for more updates from Yati Foundation.</p>';
                        }
                        ?>
                    </div>

                    <div class="article-share">
                        <span>Share:</span>
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </article>

                <a href="News.php" class="btn-ghost mt-4"><i class="fa fa-arrow-left"></i> Back to all news</a>
            </div>

            <!-- Sidebar -->
            <aside class="col-lg-4">
                <div class="sidebar-sticky">
                <div class="sidebar-box reveal">
                    <h5 class="sidebar-title">Recent Articles</h5>
                    <?php if ($recent && mysqli_num_rows($recent) > 0): ?>
                        <?php while ($r = mysqli_fetch_assoc($recent)): ?>
                            <a class="recent-item" href="NewsDetail.php?id=<?php echo (int) $r['nId']; ?>">
                                <span class="recent-thumb">
                                    <img src="admin/upload/<?php echo rawurlencode($r['file']); ?>" alt="" loading="lazy">
                                </span>
                                <span class="recent-meta">
                                    <strong><?php echo htmlspecialchars(mb_strimwidth($r['title'], 0, 50, '…')); ?></strong>
                                    <small><i class="fa fa-calendar me-1"></i><?php echo htmlspecialchars($r['addedOn']); ?></small>
                                </span>
                            </a>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-muted mb-0">No other articles yet.</p>
                    <?php endif; ?>
                </div>

                <div class="sidebar-box sidebar-cta reveal">
                    <h5>Support our cause</h5>
                    <p>Your contribution helps us keep these stories of impact going.</p>
                    <a href="Donate.php" class="orange-button w-100"><i class="fa fa-heart"></i> Donate Now</a>
                </div>
                </div><!-- /.sidebar-sticky -->
            </aside>
        </div>
    </div>
</section>

<?php include 'Includes/footer.php'; ?>
