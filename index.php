<?php
session_start();
include_once('Includes/db.php');
$pageTitle = 'Home';
$pageDesc = 'Yati Foundation works to bring education, healthcare and hope to underserved communities. Donate or volunteer today.';
include 'Includes/head.php';
?>

<!-- ===== Hero Slider ===== -->
<section class="hero">
    <div id="heroCarousel" class="carousel carousel-fade" aria-roledescription="carousel"
        aria-label="Featured foundation stories">
        <div class="carousel-indicators">
            <?php
            $slides = mysqli_query($con, "SELECT * FROM slider WHERE isDel='1' ORDER BY sId DESC");
            $slideRows = $slides ? mysqli_fetch_all($slides, MYSQLI_ASSOC) : [];
            if (empty($slideRows)) {
                // graceful fallback slide so the homepage never looks broken
                $slideRows[] = ['title' => 'Together We Can', 'quots' => 'Bringing hope to every community', 'file' => ''];
            }
            $slideTotal = count($slideRows);
            foreach ($slideRows as $i => $row): ?>
                <button type="button" data-hero-slide-to="<?php echo $i; ?>" class="<?php echo $i === 0 ? 'active' : ''; ?>"
                    aria-label="Show slide <?php echo $i + 1; ?>" <?php echo $i === 0 ? 'aria-current="true"' : ''; ?>></button>
            <?php endforeach; ?>
        </div>

        <div class="carousel-inner">
            <?php foreach ($slideRows as $i => $row):
                $slideImage = !empty($row['file']) ? 'admin/upload/' . rawurlencode($row['file']) : 'assets/images/banner-01.jpg';
                ?>
                <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>" role="group" aria-roledescription="slide"
                    aria-label="Slide <?php echo $i + 1; ?> of <?php echo $slideTotal; ?>">
                    <div class="hero-slide">
                        <div class="container hero-layout">
                            <div class="hero-content">
                                <span
                                    class="hero-kicker"><span></span><?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <h1><?php echo htmlspecialchars($row['quots'], ENT_QUOTES, 'UTF-8'); ?></h1>
                                <p>We work alongside communities to open doors to learning, wellbeing and opportunity. Be
                                    part of the change.</p>
                                <div class="hero-actions">
                                    <a href="donate.php" class="btn-brand"><i class="fa fa-heart"></i> Donate Now</a>
                                    <a href="volunteer.php" class="btn-ghost">Become a Volunteer</a>
                                </div>
                            </div>
                            <div class="hero-visual">
                                <img src="<?php echo htmlspecialchars($slideImage, ENT_QUOTES, 'UTF-8'); ?>"
                                    alt="<?php echo htmlspecialchars($row['title'] . ': ' . $row['quots'], ENT_QUOTES, 'UTF-8'); ?>"
                                    <?php echo $i === 0 ? 'fetchpriority="high" loading="eager"' : 'loading="lazy"'; ?> decoding="async">
                                <span class="hero-visual-shade"></span>
                                <span class="hero-visual-caption"><i class="fa fa-heart"></i> Hope grows when we work
                                    together</span>
                                <span
                                    class="hero-slide-number"><?php echo str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT); ?><b>/
                                        <?php echo str_pad((string) $slideTotal, 2, '0', STR_PAD_LEFT); ?></b></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($slideRows) > 1): ?>
            <button class="carousel-control-prev" type="button" data-hero-prev aria-label="Previous story">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-hero-next aria-label="Next story">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        <?php endif; ?>
    </div>
</section>

<!-- ===== Impact Stats ===== -->
<div class="container impact-bar">
    <?php $publicMetrics = mysqli_query($con, "SELECT label, metricValue, suffix, icon FROM impact_metrics WHERE isDel = 1 AND isPublished = 1 ORDER BY sortOrder, metricId LIMIT 4");
    $publicMetricRows = $publicMetrics ? mysqli_fetch_all($publicMetrics, MYSQLI_ASSOC) : [];
    if ($publicMetricRows): ?>
        <div class="impact-card reveal">
            <?php foreach ($publicMetricRows as $metric): ?>
                <div class="stat">
                    <div class="stat-icon"><i
                            class="fa <?php echo htmlspecialchars($metric['icon'], ENT_QUOTES, 'UTF-8'); ?>"></i></div>
                    <div class="stat-num" data-target="<?php echo (int) $metric['metricValue']; ?>"
                        data-suffix="<?php echo htmlspecialchars($metric['suffix'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo number_format((int) $metric['metricValue']); ?>
                        <?php echo htmlspecialchars($metric['suffix'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <div class="stat-label"><?php echo htmlspecialchars($metric['label'], ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- ===== About ===== -->
<section class="section-pad">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 reveal">
                <div class="about-img">
                    <img src="assets/images/featured.jpg" alt="Yati Foundation at work" loading="lazy" decoding="async">
                    <div class="about-badge">
                        <b>Local</b>
                        <span>Community-led work</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reveal">
                <span class="eyebrow">Who We Are</span>
                <h2 class="section-title">Building a kinder, more equal world &mdash; together</h2>
                <p>Yati Foundation is a non-profit organisation dedicated to empowering underserved communities. From
                    classrooms to clinics, we partner with local people to create lasting change in education, health
                    and livelihoods.</p>
                <ul class="feature-list">
                    <li><i class="fa fa-check"></i><span>Quality education for every child, regardless of
                            background.</span></li>
                    <li><i class="fa fa-check"></i><span>Accessible healthcare and wellness for families in need.</span>
                    </li>
                    <li><i class="fa fa-check"></i><span>Skill-building and livelihood programmes for
                            self-reliance.</span></li>
                </ul>
                <div class="mt-4 d-flex flex-wrap gap-3">
                    <a href="about-us.php" class="btn-brand">Read More</a>
                    <a href="contact-us.php" class="btn-ghost">Get In Touch</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== Values / What We Do ===== -->
<section class="section-pad bg-soft">
    <div class="container">
        <div class="section-head center reveal">
            <span class="eyebrow center">What We Do</span>
            <h2 class="section-title">Our Focus Areas</h2>
            <p class="section-lead">We channel every donation into programmes that create measurable, long-term impact
                for the people we serve.</p>
        </div>
        <div class="row g-4">
            <?php
            $homePrograms = mysqli_query($con, "SELECT title, summary, icon FROM programs WHERE isDel = 1 AND isPublished = 1 ORDER BY sortOrder, programId LIMIT 3");
            if ($homePrograms && mysqli_num_rows($homePrograms) > 0):
                while ($program = mysqli_fetch_assoc($homePrograms)): ?>
                    <div class="col-lg-4 col-md-6 reveal">
                        <div class="value-card">
                            <div class="v-icon"><i
                                    class="fa <?php echo htmlspecialchars($program['icon'], ENT_QUOTES, 'UTF-8'); ?>"></i></div>
                            <h4><?php echo htmlspecialchars($program['title'], ENT_QUOTES, 'UTF-8'); ?></h4>
                            <p><?php echo htmlspecialchars($program['summary'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                <?php endwhile;
            else: ?>
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="value-card">
                        <div class="v-icon"><i class="fa fa-graduation-cap"></i></div>
                        <h4>Education</h4>
                        <p>Scholarships, learning centres and supplies that keep children in school and dreaming big.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="value-card">
                        <div class="v-icon"><i class="fa fa-hand-holding-heart"></i></div>
                        <h4>Healthcare</h4>
                        <p>Free health camps, nutrition drives and wellness support for families who need it most.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="value-card">
                        <div class="v-icon"><i class="fa fa-seedling"></i></div>
                        <h4>Livelihoods</h4>
                        <p>Vocational training and micro-grants that help people build sustainable, independent futures.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="text-center mt-4"><a href="programs.php" class="btn-ghost">Explore our programs <i
                    class="fa fa-arrow-right"></i></a></div>
    </div>
</section>

<!-- ===== Latest stories ===== -->
<section class="section-pad home-stories bg-soft">
    <div class="container">
        <div class="home-section-heading reveal">
            <div><span class="eyebrow">From the community</span>
                <h2 class="section-title">The latest from Yati</h2>
                <p class="section-lead">Stories and updates shared by our foundation.</p>
            </div>
            <a class="btn-ghost" href="news.php">All stories <i class="fa fa-arrow-right"></i></a>
        </div>
        <div class="row g-4">
            <?php
            $homeStories = mysqli_query($con, "SELECT nId,title,file,description,addedOn FROM news WHERE isDel='1' ORDER BY nId DESC LIMIT 3");
            if ($homeStories && mysqli_num_rows($homeStories) > 0):
                while ($story = mysqli_fetch_assoc($homeStories)):
                    $storyIntro = preg_split('/\R\s*##\s+/u', (string) $story['description'], 2)[0] ?? '';
                    $storyExcerpt = trim(preg_replace('/\s+/u', ' ', strip_tags(preg_replace('/(^|\R)\s*#{1,6}\s*/u', '$1', $storyIntro))));
                    if (function_exists('mb_strimwidth'))
                        $storyExcerpt = mb_strimwidth($storyExcerpt, 0, 145, '…');
                    else
                        $storyExcerpt = substr($storyExcerpt, 0, 145) . (strlen($storyExcerpt) > 145 ? '…' : '');
                    $storyUrl = 'newsdetail.php?id=' . (int) $story['nId'];
                    $storyImage = 'admin/upload/' . rawurlencode((string) $story['file']);
                    ?>
                    <div class="col-lg-4 col-md-6 reveal">
                        <article class="news-card">
                            <a class="news-thumb" href="<?php echo $storyUrl; ?>"><img
                                    src="<?php echo htmlspecialchars($storyImage, ENT_QUOTES, 'UTF-8'); ?>"
                                    alt="<?php echo htmlspecialchars($story['title'], ENT_QUOTES, 'UTF-8'); ?>"
                                    loading="lazy" decoding="async"></a>
                            <div class="news-body"><span class="category"><i class="fa fa-calendar me-1"
                                        aria-hidden="true"></i><?php echo htmlspecialchars($story['addedOn'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <h4><a
                                        href="<?php echo $storyUrl; ?>"><?php echo htmlspecialchars($story['title'], ENT_QUOTES, 'UTF-8'); ?></a>
                                </h4>
                                <p><?php echo htmlspecialchars($storyExcerpt, ENT_QUOTES, 'UTF-8'); ?></p><a class="news-more"
                                    href="<?php echo $storyUrl; ?>">Read More <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </article>
                    </div>
                <?php endwhile; else: ?>
                <div class="col-12">
                    <div class="home-empty-note">New community stories will be shared here soon.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ===== Gallery preview ===== -->
<section class="section-pad">
    <div class="container">
        <div class="section-head center reveal">
            <span class="eyebrow center">Our Work</span>
            <h2 class="section-title">Moments of Impact</h2>
            <p class="section-lead">A glimpse into the lives we touch and the communities we serve every day.</p>
        </div>
        <div class="gallery-grid">
            <?php
            $gal = mysqli_query($con, "SELECT * FROM gallery WHERE isDel='1' ORDER BY gId DESC LIMIT 6");
            if ($gal && mysqli_num_rows($gal) > 0):
                while ($row = mysqli_fetch_assoc($gal)):
                    $img = 'admin/upload/' . rawurlencode($row['image']);
                    ?>
                    <a class="gallery-card reveal" data-lightbox="<?php echo $img; ?>">
                        <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($row['heading']); ?>" loading="lazy" decoding="async">
                        <span class="g-zoom"><i class="fa fa-expand"></i></span>
                        <div class="g-overlay">
                            <span class="gallery-photo-date"><i class="fa fa-calendar-days" aria-hidden="true"></i><?php echo htmlspecialchars($row['addedOn'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <h3><?php echo htmlspecialchars($row['heading'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        </div>
                    </a>
                <?php endwhile; else: ?>
                <p class="text-muted">Gallery coming soon.</p>
            <?php endif; ?>
        </div>
        <div class="text-center mt-5 reveal">
            <a href="gallery.php" class="btn-ghost">View Full Gallery <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<!-- ===== Get involved ===== -->
<section class="section-pad home-involve">
    <div class="container">
        <div class="home-involve-panel reveal">
            <div class="home-involve-copy"><span class="eyebrow">Be part of the change</span>
                <h2 class="section-title">A stronger community starts with people like you.</h2>
                <p>Choose how you would like to support the work: share your time, make a contribution, or learn more
                    about the foundation.</p>
            </div>
            <div class="home-involve-actions"><a class="btn-brand" href="donate.php"><i class="fa fa-heart"
                        aria-hidden="true"></i>Donate now</a><a class="btn-ghost" href="volunteer.php"><i
                        class="fa fa-people-group" aria-hidden="true"></i>Become a volunteer</a><a
                    class="home-report-link" href="reports.php"><i class="fa fa-file-lines"
                        aria-hidden="true"></i>Explore public reports</a></div>
        </div>
    </div>
</section>

<!-- Lightbox -->
<div id="lightbox"><img src="" alt="Gallery image"></div>

<?php include 'Includes/footer.php'; ?>
