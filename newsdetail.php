<?php
session_start();
include_once('Includes/db.php');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = mysqli_prepare($con, "SELECT * FROM news WHERE nId = ? AND isDel = 1 LIMIT 1");
if (!$stmt) {
    header('Location: news.php');
    exit;
}
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$article = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$article) {
    header('Location: news.php');
    exit;
}

$recentStmt = mysqli_prepare($con, "SELECT nId, title, file, addedOn FROM news WHERE isDel = 1 AND nId <> ? ORDER BY nId DESC LIMIT 4");
$recent = false;
if ($recentStmt) {
    mysqli_stmt_bind_param($recentStmt, 'i', $id);
    mysqli_stmt_execute($recentStmt);
    $recent = mysqli_stmt_get_result($recentStmt);
}

function render_article_paragraphs(string $copy): void
{
    $paragraphs = preg_split('/\R{2,}/u', trim($copy), -1, PREG_SPLIT_NO_EMPTY);
    foreach ($paragraphs as $paragraph) {
        echo '<p>' . nl2br(htmlspecialchars(trim($paragraph), ENT_QUOTES, 'UTF-8')) . '</p>';
    }
}

function render_article_sections(string $copy, string $title): void
{
    $copy = trim($copy);
    if ($copy === '') {
        echo '<p>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</p>';
        echo '<p>More details about this story will be shared soon.</p>';
        return;
    }

    $parts = preg_split('/^##\s*(.+?)\s*$/m', $copy, -1, PREG_SPLIT_DELIM_CAPTURE);
    if (count($parts) < 3) {
        render_article_paragraphs($copy);
        return;
    }

    if (trim($parts[0]) !== '') {
        echo '<div class="article-intro">';
        render_article_paragraphs($parts[0]);
        echo '</div>';
    }
    for ($index = 1; $index < count($parts); $index += 2) {
        $heading = trim($parts[$index] ?? '');
        $sectionCopy = trim($parts[$index + 1] ?? '');
        if ($heading === '') {
            continue;
        }
        echo '<section class="article-section"><h3>' . htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') . '</h3>';
        if ($sectionCopy !== '') {
            render_article_paragraphs($sectionCopy);
        }
        echo '</section>';
    }
}

$pageTitle = $article['title'];
$pageHeroEyebrow = 'Stories from the field';
$pageHeroTitle = $article['title'];
$pageHeroDescription = 'Read the full story and learn more about the work happening across our communities.';
$pageHeroAsideValue = 'Yati';
$pageHeroAsideLabel = "Stories from\nour community";
$pageHeroAsideIcon = 'fa-book-open';
$pageHeroCurrent = 'Story';
$pageHeroParentLabel = 'News';
$pageHeroParentHref = 'news.php';
$pageDesc = mb_strimwidth(strip_tags($article['description']), 0, 150, '…');
$seoTitle = $pageTitle . ' | Yati Foundation';
$seoDescription = $pageDesc;
$seoImage = 'admin/upload/' . rawurlencode((string) $article['file']);
$articleDate = DateTimeImmutable::createFromFormat('!Y-m-d', (string) $article['addedOn']);
if ($articleDate instanceof DateTimeImmutable) {
    $seoDatePublished = $articleDate->format('c');
}
include 'Includes/head.php';
include 'Includes/page-hero.php';
?>

<section class="section-pad article-page">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8 reveal">
                <article class="article">
                    <div class="article-topline"><span class="article-category">News &amp; Updates</span></div>
                    <div class="article-meta">
                        <span><i class="fa fa-calendar"></i><?php echo htmlspecialchars($article['addedOn'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <span><i class="fa fa-heart"></i>Yati Foundation</span>
                    </div>
                    <figure class="article-img">
                        <img src="admin/upload/<?php echo rawurlencode($article['file']); ?>" alt="<?php echo htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8'); ?>">
                    </figure>
                    <div class="article-body">
                        <?php render_article_sections((string) $article['description'], (string) $article['title']); ?>
                    </div>
                    <div class="article-share">
                        <span>Share this story</span>
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </article>
                <a href="news.php" class="btn-ghost article-back-link"><i class="fa fa-arrow-left"></i> Back to all news</a>
            </div>

            <aside class="col-lg-4">
                <div class="sidebar-sticky">
                    <div class="sidebar-box recent-stories-box reveal">
                        <span class="eyebrow">Keep reading</span>
                        <h5 class="sidebar-title">Recent stories</h5>
                        <?php if ($recent && mysqli_num_rows($recent) > 0): ?>
                            <?php while ($item = mysqli_fetch_assoc($recent)): ?>
                                <a class="recent-item" href="newsdetail.php?id=<?php echo (int) $item['nId']; ?>">
                                    <span class="recent-thumb"><img src="admin/upload/<?php echo rawurlencode($item['file']); ?>" alt="" loading="lazy"></span>
                                    <span class="recent-meta">
                                        <strong><?php echo htmlspecialchars(mb_strimwidth($item['title'], 0, 50, '…'), ENT_QUOTES, 'UTF-8'); ?></strong>
                                        <small><i class="fa fa-calendar"></i><?php echo htmlspecialchars($item['addedOn'], ENT_QUOTES, 'UTF-8'); ?></small>
                                    </span>
                                </a>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-muted mb-0">No other stories yet.</p>
                        <?php endif; ?>
                    </div>
                    <div class="sidebar-box sidebar-cta reveal">
                        <span class="article-cta-icon"><i class="fa fa-heart"></i></span>
                        <h5>Help create the next story</h5>
                        <p>Your support helps communities access education, healthcare and opportunity.</p>
                        <a href="donate.php" class="orange-button w-100"><i class="fa fa-heart"></i> Support our work</a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php
if ($recentStmt) {
    mysqli_stmt_close($recentStmt);
}
include 'Includes/footer.php';
?>
