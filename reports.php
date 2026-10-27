<?php
session_start();
include_once __DIR__ . '/Includes/db.php';
$pageTitle = 'Reports';
$pageDesc = 'Read annual reports and public documents published by Yati Foundation.';
$pageHeroEyebrow = 'Transparency';
$pageHeroTitle = 'Reports and';
$pageHeroHighlight = 'public documents.';
$pageHeroDescription = 'Review the documents the foundation has chosen to publish.';
$pageHeroAsideValue = 'Open';
$pageHeroAsideLabel = 'Documents for\ncommunity review';
$pageHeroAsideIcon = 'fa-file-lines';
include __DIR__ . '/Includes/head.php';
include __DIR__ . '/Includes/page-hero.php';
$items = mysqli_query($con, "SELECT title, description, category, reportYear, fileName FROM reports WHERE isDel=1 AND isPublished=1 ORDER BY reportYear DESC, reportId DESC");
?>
<main class="section-pad"><div class="container"><div class="row g-4">
<?php if ($items && mysqli_num_rows($items)): while ($item = mysqli_fetch_assoc($items)): ?>
<div class="col-lg-6"><article class="value-card h-100"><div class="v-icon"><i class="fa fa-file-pdf"></i></div><span class="eyebrow"><?php echo htmlspecialchars($item['category'], ENT_QUOTES, 'UTF-8'); ?> · <?php echo (int) $item['reportYear']; ?></span><h2 class="h4 mt-2"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></h2><p><?php echo htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8'); ?></p><a class="btn-ghost" href="admin/reports/<?php echo rawurlencode($item['fileName']); ?>" target="_blank" rel="noopener">View document <i class="fa fa-arrow-up-right-from-square"></i></a></article></div>
<?php endwhile; else: ?><div class="col-12"><div class="value-card"><h2 class="h4">Reports will appear here</h2><p class="mb-0">No public reports have been added yet.</p></div></div><?php endif; ?>
</div></div></main>
<?php include __DIR__ . '/Includes/footer.php'; ?>
