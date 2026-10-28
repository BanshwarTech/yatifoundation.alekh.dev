<?php
/**
 * Central metadata for public pages.
 * Edit this registry when a page title, description, or canonical path changes.
 */
function public_seo_config(): array
{
    return [
        'site_name' => 'Yati Foundation',
        'site_url' => 'https://yatifoundation.alekh.dev',
        'default_image' => 'assets/images/featured.jpg',
        'default_description' => 'Yati Foundation works with communities to support education, community health, and skills and livelihoods.',
        'pages' => [
            'index.php' => ['title' => 'Yati Foundation | Education, Health & Livelihoods', 'description' => 'Yati Foundation works with communities to support education, community health, and livelihoods. Discover our work, donate, or volunteer.', 'path' => '/'],
            'about-us.php' => ['title' => 'About Yati Foundation | Our Mission & Community Work', 'description' => 'Learn about Yati Foundation’s community-centred mission and work in education, community health, and skills and livelihoods.', 'path' => '/about-us'],
            'contact-us.php' => ['title' => 'Contact Yati Foundation', 'description' => 'Contact Yati Foundation with questions, partnership ideas, or to learn more about our community programmes.', 'path' => '/contact-us'],
            'donate.php' => ['title' => 'Donate to Yati Foundation | Support Community Programmes', 'description' => 'Donate to Yati Foundation to support education, community health, and livelihood opportunities for underserved communities.', 'path' => '/donate'],
            'gallery.php' => ['title' => 'Yati Foundation Gallery | Community Programme Photos', 'description' => 'Explore photos and moments from Yati Foundation programmes, events, and the communities we serve.', 'path' => '/gallery'],
            'news.php' => ['title' => 'Yati Foundation News & Community Updates', 'description' => 'Read the latest news, stories, and programme updates from Yati Foundation and the communities we serve.', 'path' => '/news'],
            'newsdetail.php' => ['title' => 'Community Story | Yati Foundation', 'description' => 'Read a story or update from Yati Foundation and the communities we serve.', 'path' => '/newsdetail.php'],
            'programs.php' => ['title' => 'Yati Foundation Programmes | Education, Health & Livelihoods', 'description' => 'Explore Yati Foundation’s work in education and learning, community health, and skills and livelihoods.', 'path' => '/programs'],
            'reports.php' => ['title' => 'Yati Foundation Reports & Public Documents', 'description' => 'Read annual reports and public documents published by Yati Foundation.', 'path' => '/reports'],
            'volunteer.php' => ['title' => 'Volunteer with Yati Foundation | Get Involved', 'description' => 'Volunteer with Yati Foundation and contribute your time and skills to education, health, and community programmes.', 'path' => '/volunteer'],
        ],
    ];
}

function public_seo_metadata(array $overrides = []): array
{
    $config = public_seo_config();
    $pageKey = basename((string) ($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
    $page = $config['pages'][$pageKey] ?? [
        'title' => $config['site_name'],
        'description' => $config['default_description'],
        'path' => '/' . rawurlencode($pageKey),
    ];
    $page = array_merge($page, $overrides);
    $path = (string) ($page['path'] ?? '/');
    $siteUrl = rtrim($config['site_url'], '/');

    if ($pageKey === 'newsdetail.php' && isset($_GET['id'])) {
        $path .= '?id=' . (int) $_GET['id'];
    }

    $image = (string) ($page['image'] ?? $config['default_image']);
    if (!preg_match('#^https?://#i', $image)) {
        $image = $siteUrl . '/' . ltrim($image, '/');
    }

    return [
        'title' => (string) $page['title'],
        'description' => (string) $page['description'],
        'canonical' => $siteUrl . $path,
        'image' => $image,
        'site_name' => $config['site_name'],
        'type' => $pageKey === 'newsdetail.php' ? 'article' : 'website',
        'date_published' => (string) ($page['date_published'] ?? ''),
    ];
}

function public_seo_structured_data(array $metadata): array
{
    $config = public_seo_config();
    $siteUrl = rtrim($config['site_url'], '/');
    $pageName = $metadata['title'];
    $data = [
        [
            '@type' => 'Organization',
            '@id' => $siteUrl . '/#organization',
            'name' => $config['site_name'],
            'url' => $siteUrl . '/',
            'description' => $config['default_description'],
        ],
        [
            '@type' => 'WebSite',
            '@id' => $siteUrl . '/#website',
            'url' => $siteUrl . '/',
            'name' => $config['site_name'],
            'publisher' => ['@id' => $siteUrl . '/#organization'],
            'inLanguage' => 'en',
        ],
        [
            '@type' => 'WebPage',
            '@id' => $metadata['canonical'] . '#webpage',
            'url' => $metadata['canonical'],
            'name' => $pageName,
            'description' => $metadata['description'],
            'isPartOf' => ['@id' => $siteUrl . '/#website'],
            'about' => ['@id' => $siteUrl . '/#organization'],
            'inLanguage' => 'en',
        ],
    ];

    if ($metadata['type'] === 'article') {
        $article = [
            '@type' => 'BlogPosting',
            'mainEntityOfPage' => ['@id' => $metadata['canonical'] . '#webpage'],
            'headline' => $metadata['title'],
            'description' => $metadata['description'],
            'image' => [$metadata['image']],
            'publisher' => ['@id' => $siteUrl . '/#organization'],
            'inLanguage' => 'en',
        ];
        if ($metadata['date_published'] !== '') {
            $article['datePublished'] = $metadata['date_published'];
        }
        $data[] = $article;
    }

    return ['@context' => 'https://schema.org', '@graph' => $data];
}
