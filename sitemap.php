<?php
require_once __DIR__ . '/Includes/db.php';
require_once __DIR__ . '/Includes/seo.php';

header('Content-Type: application/xml; charset=UTF-8');

$config = public_seo_config();
$siteUrl = rtrim($config['site_url'], '/');
$urls = [];
foreach ($config['pages'] as $pageKey => $page) {
    if ($pageKey === 'newsdetail.php') {
        continue;
    }
    $urls[] = ['loc' => $siteUrl . $page['path']];
}

$newsResult = mysqli_query($con, "SELECT nId, addedOn FROM news WHERE isDel = 1 ORDER BY nId DESC");
if ($newsResult === false) {
    error_log('Unable to load public news for sitemap: ' . mysqli_error($con));
} else {
    while ($article = mysqli_fetch_assoc($newsResult)) {
        $url = [
            'loc' => $siteUrl . '/newsdetail.php?id=' . (int) $article['nId'],
        ];
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', (string) $article['addedOn']);
        if ($date instanceof DateTimeImmutable) {
            $url['lastmod'] = $date->format('Y-m-d');
        }
        $urls[] = $url;
    }
    mysqli_free_result($newsResult);
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $url) {
    echo "  <url>\n";
    echo '    <loc>' . htmlspecialchars($url['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>\n";
    if (isset($url['lastmod'])) {
        echo '    <lastmod>' . htmlspecialchars($url['lastmod'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</lastmod>\n";
    }
    echo "  </url>\n";
}
echo "</urlset>\n";
