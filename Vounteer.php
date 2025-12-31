<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Yati Foundation</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-villa-agency.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <style>
        .nav-item {
            padding-left: 3em;
        }

        .contact-content #contact-form select {
            width: 100%;
            height: 44px;
            border-radius: 22px;
            background-color: #f6f6f6;
            border: none;
            margin-bottom: 30px;
            font-size: 14px;
            padding: 0px 15px;
        }
    </style>
    <!--

TemplateMo 591 villa agency

https://templatemo.com/tm-591-villa-agency

-->
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <?php include('Includes/header.php') ?>

    <!-- ***** Header Area End ***** -->

    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="breadcrumb"><a href="#">Home</a> / Volunteer</span>
                    <h3>Volunteer</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-page section">
        <div class="container ">
            <div class="row">
                <div class="col-lg-12">
                    <form id="contact-form" action="Includes/code.php?msg=add-volunteer" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-12">
                                <fieldset>
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name" id="name" placeholder="Your Name..." autocomplete="on" style="border-color: black;" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12 ">
                                <fieldset>
                                    <label for="mobile">Mobile Number</label>
                                    <input type="number" name="mobile" id="mobile" placeholder="Your Mobile Number..." style="border-color: black;" required="">
                                </fieldset>
                            </div>
                            <div class="col-lg-12 ">
                                <fieldset>
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" placeholder="Your E-mail..." style="border-color: black;" required="">
                                </fieldset>
                            </div>
                            <div class="col-lg-12  ">
                                <fieldset>
                                    <label for="profile">Profile</label>
                                    <input type="file" name="profile" style="border-color: black;">
                                </fieldset>
                            </div>
                            <div class="col-lg-12  ">
                                <fieldset>
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" placeholder="Your Address" style="border-color: black;"></textarea>
                                </fieldset>
                            </div>
                            <div class="col-lg-12  ">
                                <fieldset>
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender">
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="orange-button" name="btnVounteer">Donate Now</button>
                                </fieldset>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="col-lg-8">
                <p>Copyright © 2048 Villa Agency Co., Ltd. All rights reserved.

                    Design: <a rel="nofollow" href="https://templatemo.com" target="_blank">TemplateMo</a> Distribution: <a href="https://themewagon.com">ThemeWagon</a></p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/isotope.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/counter.js"></script>
    <script src="assets/js/custom.js"></script>

</body>

</html>