<?php
$pageTitle = 'Donate';
$pageDesc  = 'Make a donation to Yati Foundation and help fund education, healthcare and livelihoods for those in need.';
include 'Includes/head.php';
?>

<section class="page-heading">
    <div class="container">
        <h1>Donate</h1>
        <div class="breadcrumb-nav"><a href="index.php">Home</a> &nbsp;/&nbsp; Donate</div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 reveal">
                <span class="eyebrow">Make a Difference</span>
                <h2 class="section-title">Your gift changes lives</h2>
                <p>Every contribution &mdash; big or small &mdash; helps us bring education, healthcare and hope to
                    families who need it most. 100% of your donation goes directly to our programmes on the ground.</p>
                <ul class="feature-list">
                    <li><i class="fa fa-check"></i><span><b>₹500</b> can provide school supplies for a child for a term.</span></li>
                    <li><i class="fa fa-check"></i><span><b>₹2,000</b> can fund a community health check-up camp.</span></li>
                    <li><i class="fa fa-check"></i><span><b>₹5,000</b> can support vocational training for a young adult.</span></li>
                </ul>
            </div>
            <div class="col-lg-7 reveal">
                <div class="form-card">
                    <form id="contact-form" action="Includes/code.php?msg=add-donate" method="post">
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
                            <div class="col-12">
                                <fieldset>
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" placeholder="you@example.com" required>
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <fieldset>
                                    <label>Choose an amount (₹)</label>
                                    <div class="amount-chips">
                                        <span class="amount-chip" data-amount="500">₹500</span>
                                        <span class="amount-chip" data-amount="1000">₹1,000</span>
                                        <span class="amount-chip" data-amount="2000">₹2,000</span>
                                        <span class="amount-chip" data-amount="5000">₹5,000</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" min="1" placeholder="Or enter a custom amount" required>
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <fieldset>
                                    <label for="donation">Purpose of Donation</label>
                                    <textarea name="donation" id="donation" placeholder="e.g. Education, Healthcare, General fund"></textarea>
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <fieldset>
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" placeholder="Your address"></textarea>
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="orange-button w-100" name="btnDonate">
                                    <i class="fa fa-heart"></i> Donate Now
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
