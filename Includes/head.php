<?php
/**
 * Shared <head> + opening <body> + header.
 * Set $pageTitle (and optionally $pageDesc) before including this file.
 */
$pageTitle = isset($pageTitle) ? $pageTitle : 'Yati Foundation';
$pageDesc  = isset($pageDesc) ? $pageDesc : 'Yati Foundation — empowering communities through education, health and compassion.';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo htmlspecialchars($pageDesc); ?>">
    <meta name="theme-color" content="#f35525">
    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg?v=2">

    <title><?php echo htmlspecialchars($pageTitle); ?> | Yati Foundation</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS (local) -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons + theme -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo @filemtime(__DIR__ . '/../assets/css/style.css'); ?>">
</head>

<body>

    <!-- Preloader -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <div class="dots"><span></span><span></span><span></span></div>
        </div>
    </div>

    <?php include __DIR__ . '/header.php'; ?>
