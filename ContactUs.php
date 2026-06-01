<?php
$pageTitle = 'Contact Us';
$pageDesc  = 'Get in touch with Yati Foundation. We would love to hear from you.';
include 'Includes/head.php';
?>

<section class="page-heading">
    <div class="container">
        <h1>Contact Us</h1>
        <div class="breadcrumb-nav"><a href="index.php">Home</a> &nbsp;/&nbsp; Contact Us</div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 reveal">
                <span class="eyebrow">Get In Touch</span>
                <h2 class="section-title">We'd love to hear from you</h2>
                <p>Have a question, a partnership idea, or want to learn more about our work? Reach out &mdash; our team
                    will get back to you as soon as we can.</p>

                <div class="contact-info-item">
                    <div class="ci-icon"><i class="fa fa-location-dot"></i></div>
                    <h6>123 Hope Street, New Delhi<span>India 110001</span></h6>
                </div>
                <div class="contact-info-item">
                    <div class="ci-icon"><i class="fa fa-phone-volume"></i></div>
                    <h6>+91 96969 69696<span>Mon–Sat, 9am to 6pm</span></h6>
                </div>
                <div class="contact-info-item">
                    <div class="ci-icon"><i class="fa fa-envelope"></i></div>
                    <h6>care@yatifoundation.org<span>We reply within 24 hours</span></h6>
                </div>
            </div>

            <div class="col-lg-7 reveal">
                <div class="form-card">
                    <form id="contact-form" action="Includes/code.php?msg=add-contact" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name" id="name" placeholder="Your name" required>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" placeholder="you@example.com" required>
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <fieldset>
                                    <label for="subject">Subject</label>
                                    <input type="text" name="subject" id="subject" placeholder="How can we help?">
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <fieldset>
                                    <label for="message">Message</label>
                                    <textarea name="message" id="message" placeholder="Your message..." required></textarea>
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="orange-button w-100" name="btnContact">
                                    <i class="fa fa-paper-plane"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 reveal">
                <div id="map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.0!2d77.2090!3d28.6139!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjjCsDM2JzUwLjAiTiA3N8KwMTInMzIuNCJF!5e0!3m2!1sen!2sin!4v1700000000000"
                        height="450" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'Includes/footer.php'; ?>
