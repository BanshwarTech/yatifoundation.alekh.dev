<?php
/**
 * Shared <head> + opening <body> + header.
 * Set $pageTitle (and optionally $pageDesc) before including this file.
 */
$pageTitle = isset($pageTitle) ? $pageTitle : 'Yati Foundation';
$pageDesc  = isset($pageDesc) ? $pageDesc : 'Yati Foundation — empowering communities through education, health and compassion.';
require_once __DIR__ . '/seo.php';
$seoOverrides = array_filter([
    'description' => isset($seoDescription) ? $seoDescription : null,
    'title' => isset($seoTitle) ? $seoTitle : null,
    'image' => isset($seoImage) ? $seoImage : null,
    'date_published' => isset($seoDatePublished) ? $seoDatePublished : null,
], static function ($value): bool {
    return $value !== null;
});
$seoMetadata = public_seo_metadata($seoOverrides);
$seoStructuredData = public_seo_structured_data($seoMetadata);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo htmlspecialchars($seoMetadata['description'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="theme-color" content="#f35525">
    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg?v=2">
    <link rel="canonical" href="<?php echo htmlspecialchars($seoMetadata['canonical'], ENT_QUOTES, 'UTF-8'); ?>">

    <title><?php echo htmlspecialchars($seoMetadata['title'], ENT_QUOTES, 'UTF-8'); ?></title>
    <meta property="og:type" content="<?php echo htmlspecialchars($seoMetadata['type'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:site_name" content="<?php echo htmlspecialchars($seoMetadata['site_name'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($seoMetadata['title'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($seoMetadata['description'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($seoMetadata['canonical'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($seoMetadata['image'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($seoMetadata['title'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($seoMetadata['description'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($seoMetadata['image'], ENT_QUOTES, 'UTF-8'); ?>">
    <script type="application/ld+json"><?php echo json_encode($seoStructuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS (local) -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons + theme -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo @filemtime(__DIR__ . '/../assets/css/style.css'); ?>">
    <link rel="stylesheet" href="assets/css/custom-select.css?v=<?php echo @filemtime(__DIR__ . '/../assets/css/custom-select.css'); ?>">
</head>

<body>

    <!-- Preloader -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <div class="dots"><span></span><span></span><span></span></div>
        </div>
    </div>

    <?php include __DIR__ . '/header.php'; ?>
