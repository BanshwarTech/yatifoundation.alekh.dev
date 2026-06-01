<?php
session_start();
include_once('Includes/db.php');
$pageTitle = 'Home';
$pageDesc  = 'Yati Foundation works to bring education, healthcare and hope to underserved communities. Donate or volunteer today.';
include 'Includes/head.php';
?>

<!-- ===== Hero Slider ===== -->
<section class="hero">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php
            $slides = mysqli_query($con, "SELECT * FROM slider WHERE isDel='1'");
            $slideRows = $slides ? mysqli_fetch_all($slides, MYSQLI_ASSOC) : [];
            if (empty($slideRows)) {
                // graceful fallback slide so the homepage never looks broken
                $slideRows[] = ['title' => 'Together We Can', 'quots' => 'Bringing hope to every community', 'file' => ''];
            }
            foreach ($slideRows as $i => $row): ?>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?php echo $i; ?>"
                    class="<?php echo $i === 0 ? 'active' : ''; ?>" aria-label="Slide <?php echo $i + 1; ?>"></button>
            <?php endforeach; ?>
        </div>

        <div class="carousel-inner">
            <?php foreach ($slideRows as $i => $row):
                $bg = $row['file'] !== '' ? 'admin/upload/' . rawurlencode($row['file']) : 'assets/images/banner-01.jpg';
            ?>
                <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                    <div class="hero-slide" style="background-image:url('<?php echo $bg; ?>');">
                        <div class="container">
                            <div class="hero-content">
                                <span class="category"><em><?php echo htmlspecialchars($row['title']); ?></em></span>
                                <h1><?php echo htmlspecialchars($row['quots']); ?></h1>
                                <p>Join Yati Foundation in our mission to uplift communities through education, health
                                    and compassion. Your support changes lives.</p>
                                <div class="hero-actions">
                                    <a href="Donate.php" class="btn-brand"><i class="fa fa-heart"></i> Donate Now</a>
                                    <a href="Vounteer.php" class="btn-ghost">Become a Volunteer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($slideRows) > 1): ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        <?php endif; ?>
    </div>
</section>

<!-- ===== Impact Stats ===== -->
<div class="container impact-bar">
    <div class="impact-card reveal">
        <div class="stat">
            <div class="stat-icon"><i class="fa fa-hand-holding-heart"></i></div>
            <div class="stat-num" data-target="12500">0</div>
            <div class="stat-label">Lives Touched</div>
        </div>
        <div class="stat">
            <div class="stat-icon"><i class="fa fa-users"></i></div>
            <div class="stat-num" data-target="850">0</div>
            <div class="stat-label">Active Volunteers</div>
        </div>
        <div class="stat">
            <div class="stat-icon"><i class="fa fa-seedling"></i></div>
            <div class="stat-num" data-target="120">0</div>
            <div class="stat-label">Projects Completed</div>
        </div>
        <div class="stat">
            <div class="stat-icon"><i class="fa fa-award"></i></div>
            <div class="stat-num" data-target="14">0</div>
            <div class="stat-label">Years of Service</div>
        </div>
    </div>
</div>

<!-- ===== About ===== -->
<section class="section-pad">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 reveal">
                <div class="about-img">
                    <img src="assets/images/featured.jpg" alt="Yati Foundation at work">
                    <div class="about-badge">
                        <b>14+</b>
                        <span>Years serving communities</span>
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
                    <li><i class="fa fa-check"></i><span>Quality education for every child, regardless of background.</span></li>
                    <li><i class="fa fa-check"></i><span>Accessible healthcare and wellness for families in need.</span></li>
                    <li><i class="fa fa-check"></i><span>Skill-building and livelihood programmes for self-reliance.</span></li>
                </ul>
                <div class="mt-4 d-flex flex-wrap gap-3">
                    <a href="AboutUs.php" class="btn-brand">Read More</a>
                    <a href="ContactUs.php" class="btn-ghost">Get In Touch</a>
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
                        <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($row['heading']); ?>" loading="lazy">
                        <span class="g-zoom"><i class="fa fa-expand"></i></span>
                        <div class="g-overlay">
                            <span class="category"><?php echo htmlspecialchars($row['heading']); ?></span>
                            <h6><?php echo htmlspecialchars($row['addedOn']); ?></h6>
                        </div>
                    </a>
            <?php endwhile; else: ?>
                <p class="text-muted">Gallery coming soon.</p>
            <?php endif; ?>
        </div>
        <div class="text-center mt-5 reveal">
            <a href="Gallery.php" class="btn-ghost">View Full Gallery <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<!-- ===== CTA ===== -->
<section class="section-pad bg-soft">
    <div class="container">
        <div class="cta-band reveal">
            <h2>Your generosity can change a life today</h2>
            <p>Every rupee you give goes directly towards education, healthcare and hope for those who need it most.</p>
            <a href="Donate.php" class="btn-light-pill"><i class="fa fa-heart me-2"></i>Donate Now</a>
        </div>
    </div>
</section>

<!-- Lightbox -->
<div id="lightbox"><img src="" alt="Gallery image"></div>

<?php include 'Includes/footer.php'; ?>
