<?php
session_start();
require_once __DIR__ . '/Includes/db.php';
require_once __DIR__ . '/payment/gateways.php';
$availablePaymentGateways = payment_available_gateways();
$pageTitle = 'Donate';
$pageHeroEyebrow = 'Make a difference';
$pageHeroTitle = 'Your kindness can';
$pageHeroHighlight = 'change a life.';
$pageHeroDescription = 'Your contribution helps bring education, healthcare and opportunity closer to families who need support.';
$pageHeroAsideValue = 'Transparent';
$pageHeroAsideLabel = "Pledges recorded\npayment verified";
$pageHeroAsideIcon = 'fa-heart';
$pageHeroCurrent = 'Donate';
$pageDesc  = 'Make a donation to Yati Foundation and help fund education, healthcare and livelihoods for those in need.';
include 'Includes/head.php';
include 'Includes/page-hero.php';
?>

<section class="section-pad">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 reveal">
                <p>Choose Razorpay or Cashfree for online checkout when enabled. If online payment is unavailable, you can still submit a pledge and the team will follow up.</p>
                <ul class="feature-list">
                    <li><i class="fa fa-check"></i><span><b>₹500</b> can provide school supplies for a child for a term.</span></li>
                    <li><i class="fa fa-check"></i><span><b>₹2,000</b> can fund a community health check-up camp.</span></li>
                    <li><i class="fa fa-check"></i><span><b>₹5,000</b> can support vocational training for a young adult.</span></li>
                </ul>
            </div>
            <div class="col-lg-7 reveal">
                <div class="form-card">
                    <form id="contact-form" action="Includes/code.php?msg=add-donate" method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(public_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>"><div class="d-none" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
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
                            <?php if ($availablePaymentGateways): ?>
                            <div class="col-12">
                                <fieldset>
                                    <label for="payment_gateway">Payment method</label>
                                    <select name="payment_gateway" id="payment_gateway" required>
                                        <?php foreach ($availablePaymentGateways as $gatewayKey => $gateway): ?><option value="<?php echo htmlspecialchars($gatewayKey, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($gateway['label'], ENT_QUOTES, 'UTF-8'); ?> secure checkout</option><?php endforeach; ?>
                                    </select>
                                    <small class="form-text">Payment is confirmed after secure server-side verification.</small>
                                </fieldset>
                            </div>
                            <?php else: ?>
                            <div class="col-12"><div class="about-inline-note"><i class="fa fa-circle-info"></i><span>Online checkout is not configured yet. Submit your pledge and the foundation team can follow up.</span></div></div>
                            <?php endif; ?>
                            <div class="col-12">
                                <fieldset>
                                    <label for="donation">Purpose of Donation</label>
                                    <textarea name="donation" id="donation" placeholder="e.g. Education, Healthcare, General fund" required></textarea>
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
