<?php
$pageTitle = 'Volunteer';
$pageDesc  = 'Volunteer with Yati Foundation and give your time and skills to causes that matter.';
include 'Includes/head.php';
?>

<section class="page-heading">
    <div class="container">
        <h1>Volunteer</h1>
        <div class="breadcrumb-nav"><a href="index.php">Home</a> &nbsp;/&nbsp; Volunteer</div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 reveal">
                <span class="eyebrow">Join Our Team</span>
                <h2 class="section-title">Give your time, change a life</h2>
                <p>Our volunteers are the heart of Yati Foundation. Whether you can spare a few hours a week or join a
                    field project, there is a place for you. Share your skills, meet inspiring people, and be part of
                    real change.</p>
                <ul class="feature-list">
                    <li><i class="fa fa-check"></i><span>Teach and mentor children in our learning centres.</span></li>
                    <li><i class="fa fa-check"></i><span>Support health camps and community outreach drives.</span></li>
                    <li><i class="fa fa-check"></i><span>Lend professional skills &mdash; design, tech, fundraising and more.</span></li>
                </ul>
            </div>
            <div class="col-lg-7 reveal">
                <div class="form-card">
                    <form id="contact-form" action="Includes/code.php?msg=add-volunteer" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name" id="name" placeholder="Your name" required>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <label for="mobile">Mobile Number</label>
                                    <input type="tel" name="mobile" id="mobile" placeholder="Your mobile number" required>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" placeholder="you@example.com" required>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender">
                                        <option value="">Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <fieldset>
                                    <label for="profile">Profile Photo</label>
                                    <input type="file" name="profile" id="profile" accept="image/png, image/jpeg">
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <fieldset>
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" placeholder="Your address"></textarea>
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="orange-button w-100" name="btnVounteer">
                                    <i class="fa fa-hands-helping"></i> Become a Volunteer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'Includes/footer.php'; ?>
