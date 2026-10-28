<?php
$adminPageTitle = isset($adminPageTitle) && trim((string) $adminPageTitle) !== ''
    ? trim((string) $adminPageTitle)
    : 'Administration';
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex, nofollow, noarchive">
    <meta name="theme-color" content="#0e1426">
    <title><?php echo htmlspecialchars($adminPageTitle, ENT_QUOTES, 'UTF-8'); ?> | Yati Foundation</title>
    <link rel="icon" type="image/svg+xml" href="../assets/images/favicon.svg?v=2">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/admin-theme.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
