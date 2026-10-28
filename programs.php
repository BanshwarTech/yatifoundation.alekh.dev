<?php
session_start();
require_once __DIR__ . '/Includes/db.php';
$pageTitle = 'Our Programs';
$pageDesc = 'Explore Yati Foundation’s focus areas, programme approach and ways to participate.';
$pageHeroEyebrow = 'Where we focus';
$pageHeroTitle = 'Practical support.';
$pageHeroHighlight = 'Stronger communities.';
$pageHeroDescription = 'Explore the areas of work at the heart of Yati Foundation and learn how to get involved.';
$pageHeroAsideValue = '3 areas';
$pageHeroAsideLabel = "Learning, health\nand livelihoods";
$pageHeroAsideIcon = 'fa-seedling';
$pageHeroCurrent = 'Programs';
include __DIR__ . '/Includes/head.php';
include __DIR__ . '/Includes/page-hero.php';
$items = mysqli_query($con, "SELECT title, summary, description, icon FROM programs WHERE isDel=1 AND isPublished=1 ORDER BY sortOrder, programId");
?>
<main>
    <section class="section-pad programs-intro-section">
        <div class="container">
            <div class="programs-intro-panel reveal">
                <div><span class="eyebrow">Our programme approach</span><h2>Start with what communities say they need.</h2></div>
                <p>Our focus areas connect everyday needs with opportunities to learn, improve wellbeing and build livelihoods. The activities available can vary by location and time. Contact us for current programme information.</p>
            </div>
        </div>
    </section>

    <section class="section-pad bg-soft" id="focus-areas">
        <div class="container">
            <div class="section-head center reveal"><span class="eyebrow center">Focus areas</span><h2 class="section-title">Explore our programs</h2><p class="section-lead">Each area responds to a different part of community wellbeing. Read the current overview and ask us about local activities.</p></div>
            <div class="row g-4">
                <?php if ($items && mysqli_num_rows($items)): $programIndex = 0; while ($item = mysqli_fetch_assoc($items)): $programIndex++; ?>
                    <div class="col-lg-4 col-md-6 reveal">
                        <article class="program-detail-card h-100">
                            <div class="program-card-top"><span class="program-card-icon"><i class="fa <?php echo htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i></span><span class="program-card-number"><?php echo str_pad((string)$programIndex, 2, '0', STR_PAD_LEFT); ?></span></div>
                            <span class="eyebrow">Yati Foundation focus</span>
                            <h3><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p class="program-card-summary"><?php echo nl2br(htmlspecialchars($item['summary'], ENT_QUOTES, 'UTF-8')); ?></p>
                            <?php if (trim($item['description']) !== ''): ?><div class="program-card-description"><?php echo nl2br(htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8')); ?></div><?php endif; ?>
                            <a href="contact-us.php" class="text-link">Ask about this area <i class="fa fa-arrow-right"></i></a>
                        </article>
                    </div>
                <?php endwhile; else: ?>
                    <div class="col-12"><div class="value-card"><h3 class="h4">Program information is being prepared</h3><p class="mb-0">Please contact the foundation for current information.</p></div></div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section-pad">
        <div class="container">
            <div class="gallery-section-heading reveal"><div><span class="eyebrow">Our way of working</span><h2 class="section-title">A shared programme journey</h2></div><p class="section-lead">We value listening, practical action and learning from community feedback.</p></div>
            <div class="row g-4 programs-steps">
                <div class="col-md-6 col-lg-3 reveal"><article class="program-step-card"><span>01</span><h3>Understand</h3><p>Listen to local priorities and identify existing community strengths.</p></article></div>
                <div class="col-md-6 col-lg-3 reveal"><article class="program-step-card"><span>02</span><h3>Shape support</h3><p>Define activities and expectations with the people and partners involved.</p></article></div>
                <div class="col-md-6 col-lg-3 reveal"><article class="program-step-card"><span>03</span><h3>Participate</h3><p>Connect interested community members and volunteers with suitable opportunities.</p></article></div>
                <div class="col-md-6 col-lg-3 reveal"><article class="program-step-card"><span>04</span><h3>Learn</h3><p>Use feedback and verified information to review what can improve.</p></article></div>
            </div>
        </div>
    </section>

    <section class="section-pad bg-soft">
        <div class="container">
            <div class="section-head center reveal"><span class="eyebrow center">Take part</span><h2 class="section-title">Find a way to contribute</h2><p class="section-lead">The right next step depends on your interests, skills and the opportunities currently available.</p></div>
            <div class="row g-4">
                <div class="col-lg-4 reveal"><article class="value-card h-100"><div class="v-icon"><i class="fa fa-hands-helping"></i></div><h3 class="h4">Volunteer</h3><p>Tell us about your experience and the kind of support you would like to offer.</p><a href="volunteer.php" class="text-link">Apply to volunteer <i class="fa fa-arrow-right"></i></a></article></div>
                <div class="col-lg-4 reveal"><article class="value-card h-100"><div class="v-icon"><i class="fa fa-heart"></i></div><h3 class="h4">Support a programme</h3><p>Submit a donation pledge and the foundation team can follow up with next steps.</p><a href="donate.php" class="text-link">Make a pledge <i class="fa fa-arrow-right"></i></a></article></div>
                <div class="col-lg-4 reveal"><article class="value-card h-100"><div class="v-icon"><i class="fa fa-message"></i></div><h3 class="h4">Ask a question</h3><p>Contact us to ask about current activities, participation or partnerships.</p><a href="contact-us.php" class="text-link">Contact us <i class="fa fa-arrow-right"></i></a></article></div>
            </div>
        </div>
    </section>

    <section class="section-pad">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7 reveal"><span class="eyebrow">Transparency</span><h2 class="section-title">Follow the work with clear information</h2><p class="section-lead">We will share public reports and impact figures here when the foundation has reviewed and confirmed them. We do not publish unverified totals.</p></div>
                <div class="col-lg-5 reveal"><div class="about-trust-links"><a href="reports.php"><span><i class="fa fa-file-lines"></i><b>Reports</b><small>Read public documents</small></span><i class="fa fa-arrow-right"></i></a><a href="about-us.php"><span><i class="fa fa-circle-info"></i><b>About the foundation</b><small>Our mission and approach</small></span><i class="fa fa-arrow-right"></i></a></div></div>
            </div>
        </div>
    </section>

    <section class="section-pad bg-soft">
        <div class="container">
            <div class="section-head center reveal"><span class="eyebrow center">Good to know</span><h2 class="section-title">Questions about our programs</h2><p class="section-lead">For the latest activity details, please contact the foundation directly.</p></div>
            <div class="program-faq-list">
                <details class="program-faq reveal"><summary>Are all programs open in every location?</summary><p>Availability can vary by location and time. Contact the foundation to ask which activities are currently running near you.</p></details>
                <details class="program-faq reveal"><summary>How can I take part?</summary><p>You can submit a volunteer application or send a message about your interest. The team can follow up about suitable opportunities.</p></details>
                <details class="program-faq reveal"><summary>Where can I find public updates?</summary><p>Published reports and verified impact information will be listed on the <a href="reports.php">Reports page</a> when available.</p></details>
            </div>
        </div>
    </section>

    <section class="section-pad bg-soft"><div class="container"><div class="cta-band reveal"><h2>Interested in a program?</h2><p>Get in touch to ask about current activities and ways to participate.</p><a href="contact-us.php" class="btn-light-pill"><i class="fa fa-paper-plane me-2"></i>Contact the foundation</a></div></div></section>
</main>
<?php include __DIR__ . '/Includes/footer.php'; ?>
