<?php
session_start();
include_once __DIR__ . '/Includes/db.php';
$items = mysqli_query($con, "SELECT title, description, category, reportYear, fileName FROM reports WHERE isDel=1 AND isPublished=1 ORDER BY reportYear DESC, reportId DESC");
$reportCount = $items ? mysqli_num_rows($items) : 0;
if (!$items) {
    error_log('Unable to load public reports: ' . mysqli_error($con));
    http_response_code(500);
}
$pageTitle = 'Reports';
$pageDesc = 'Read annual reports and public documents published by Yati Foundation.';
$pageHeroEyebrow = 'Transparency';
$pageHeroTitle = 'Reports and';
$pageHeroHighlight = 'public documents.';
$pageHeroDescription = 'Explore the reports and public documents Yati Foundation shares with the community.';
$pageHeroAsideValue = (string) $reportCount;
$pageHeroAsideLabel = "Published\npublic documents";
$pageHeroAsideIcon = 'fa-file-lines';
$pageHeroCurrent = 'Reports';
include __DIR__ . '/Includes/head.php';
include __DIR__ . '/Includes/page-hero.php';
?>
<main>
    <section class="section-pad reports-intro-section">
        <div class="container">
            <div class="programs-intro-panel reports-intro-panel reveal">
                <div><span class="eyebrow">Open and accountable</span><h2>Information to read, share, and review.</h2></div>
                <p>Browse public documents from Yati Foundation. Each report includes its category and reporting year, so you can quickly find the information you need.</p>
            </div>
        </div>
    </section>

    <section class="section-pad bg-soft reports-library-section">
        <div class="container">
            <div class="gallery-section-heading reveal">
                <div><span class="eyebrow">Public library</span><h2 class="section-title">Reports and resources</h2></div>
                <p class="section-lead">Open a document to read it in a new tab or save a copy for later.</p>
            </div>
            <?php if (!$items): ?>
                <div class="reports-empty-state reveal"><span class="reports-empty-icon"><i class="fa fa-circle-exclamation" aria-hidden="true"></i></span><h3>Reports are temporarily unavailable</h3><p class="mb-0">Please try again later.</p></div>
            <?php elseif ($reportCount): ?>
                <div class="row g-4">
                    <?php while ($item = mysqli_fetch_assoc($items)): ?>
                        <div class="col-lg-6 reveal">
                            <article class="report-card h-100">
                                <div class="report-card-top">
                                    <span class="report-document-art" aria-hidden="true"><i class="fa fa-file-pdf"></i><span>PDF</span></span>
                                    <div class="report-card-meta">
                                        <span class="report-category"><?php echo htmlspecialchars($item['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                                        <span class="report-year"><i class="fa fa-calendar" aria-hidden="true"></i><?php echo (int) $item['reportYear']; ?></span>
                                    </div>
                                </div>
                                <div class="report-card-content">
                                    <h3><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <p><?php echo htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                                </div>
                                <div class="report-card-footer">
                                    <span><i class="fa fa-arrow-up-right-from-square" aria-hidden="true"></i> Opens in a new tab</span>
                                    <a class="btn-brand" href="admin/reports/<?php echo rawurlencode($item['fileName']); ?>" target="_blank" rel="noopener">View report <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </div>
                            </article>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="reports-empty-state reveal"><span class="reports-empty-icon"><i class="fa fa-file-lines" aria-hidden="true"></i></span><h3>Reports are on the way</h3><p class="mb-0">There are no public reports to show right now. Please check back soon.</p></div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include __DIR__ . '/Includes/footer.php'; ?>
