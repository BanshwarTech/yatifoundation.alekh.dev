<?php /** Shared footer + scripts */ ?>
<footer class="site-footer">
    <div class="container">
        <div class="row gy-5">
            <div class="col-lg-4 col-md-6">
                <a class="navbar-brand-yati" href="index.php">
                    <span class="brand-mark"><i class="fa fa-hand-holding-heart" aria-hidden="true"></i></span>
                    <span class="brand-copy" style="color:#fff"><span>Yati<b>Foundation</b></span><small>Care. Hope. Change.</small></span>
                </a>
                <p>We work hand in hand with communities to deliver education, healthcare and hope where it is needed
                    most. Every contribution helps us build a brighter, more equal future.</p>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="X (formerly Twitter)"><svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.634 7.584H.478l8.6-9.83L0 1.154h7.594l5.243 6.932z"/></svg></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <h5>Explore</h5>
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="reports.php">Reports</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <h5>Get Involved</h5>
                <ul class="footer-links">
                    <li><a href="donate.php">Donate</a></li>
                    <li><a href="volunteer.php">Volunteer</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                    <li><a href="login.php"><i class="fa fa-lock me-1"></i>Admin Login</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-6">
                <h5>Reach Us</h5>
                <p>Have a question or want to work with us? Use the Contact page from the main navigation to send the team a message.</p>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
            <span>&copy; <?php echo date('Y'); ?> Yati Foundation. All rights reserved.</span>
            <div class="footer-bottom-links">
                <a href="sitemap.xml"><i class="fa fa-sitemap" aria-hidden="true"></i> Sitemap</a>
                <span>Made with <i class="fa fa-heart" aria-hidden="true"></i> for a better world.</span>
            </div>
        </div>
    </div>
</footer>

<button class="back-to-top" id="backToTop" type="button" aria-label="Back to top" title="Back to top">
    <i class="fa fa-arrow-up" aria-hidden="true"></i>
</button>

<?php
require_once __DIR__ . '/toast.php';
render_app_toast();
?>

<!-- Scripts -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/toast.js"></script>
</body>

</html>
