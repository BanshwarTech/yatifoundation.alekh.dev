<?php
$heroEyebrow = $pageHeroEyebrow ?? 'Yati Foundation';
$heroTitle = $pageHeroTitle ?? ($pageTitle ?? 'Yati Foundation');
$heroHighlight = $pageHeroHighlight ?? '';
$heroDescription = $pageHeroDescription ?? ($pageDesc ?? 'Together, we create lasting change in our communities.');
$heroAsideValue = $pageHeroAsideValue ?? 'Together';
$heroAsideLabel = $pageHeroAsideLabel ?? 'Care that creates\nlasting change';
$heroAsideIcon = $pageHeroAsideIcon ?? 'fa-heart';
$heroCurrent = $pageHeroCurrent ?? ($pageTitle ?? 'Page');
$heroParentLabel = $pageHeroParentLabel ?? '';
$heroParentHref = $pageHeroParentHref ?? '';
?>
<section class="site-page-hero">
    <div class="container site-page-hero-inner">
        <div class="site-page-hero-copy">
            <span class="site-page-hero-eyebrow"><i></i><?php echo htmlspecialchars($heroEyebrow, ENT_QUOTES, 'UTF-8'); ?></span>
            <h1><?php echo htmlspecialchars($heroTitle, ENT_QUOTES, 'UTF-8'); ?><?php if ($heroHighlight !== ''): ?><br><span><?php echo htmlspecialchars($heroHighlight, ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?></h1>
            <p><?php echo htmlspecialchars($heroDescription, ENT_QUOTES, 'UTF-8'); ?></p>
            <nav class="site-page-breadcrumb" aria-label="Breadcrumb">
                <a href="index.php">Home</a>
                <?php if ($heroParentLabel !== '' && $heroParentHref !== ''): ?><i class="fa fa-chevron-right" aria-hidden="true"></i><a href="<?php echo htmlspecialchars($heroParentHref, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($heroParentLabel, ENT_QUOTES, 'UTF-8'); ?></a><?php endif; ?>
                <i class="fa fa-chevron-right" aria-hidden="true"></i><span aria-current="page"><?php echo htmlspecialchars($heroCurrent, ENT_QUOTES, 'UTF-8'); ?></span>
            </nav>
        </div>
        <aside class="site-page-hero-aside" aria-label="<?php echo htmlspecialchars($heroAsideValue . ' ' . str_replace("\n", ' ', $heroAsideLabel), ENT_QUOTES, 'UTF-8'); ?>">
            <span class="site-page-hero-icon"><i class="fa <?php echo htmlspecialchars($heroAsideIcon, ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i></span>
            <strong><?php echo htmlspecialchars($heroAsideValue, ENT_QUOTES, 'UTF-8'); ?></strong>
            <span><?php echo nl2br(htmlspecialchars($heroAsideLabel, ENT_QUOTES, 'UTF-8')); ?></span>
            <i class="fa fa-star site-page-hero-star" aria-hidden="true"></i>
        </aside>
    </div>
</section>
