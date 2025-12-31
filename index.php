<?php
session_start();
include_once('Includes/db.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

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

    <div class="main-banner">
        <div class="owl-carousel owl-banner">
            <?php

            $select = "SELECT * FROM slider WHERE isDel='1'";
            // echo $select;
            $result = mysqli_query($con, $select);
            if (!$result == "") {
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="item item-1" style="background-image: url(admin/upload/<?php echo $row["file"] ?>);">
                        <div class="header-text">
                            <span class="category"><em>
                                    <?php echo $row["title"] ?>
                                </em></span>
                            <h2>
                                <?php echo $row["quots"] ?>
                            </h2>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
    </div>

    <div class="featured section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-4">
                    <div class="section-heading text-center">
                        <h2>About</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-content">
                        <p>Get <strong>Yati Foundation</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                            irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
                            anim id est laborum.

                            <br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                            in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                            sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                            laborum. <a href="AboutUs.php" style="color:#F35525;">Read More</a>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>





    <div class="section best-deal">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-4">
                    <div class="section-heading text-center">
                        <h2>Gallery</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php

                $select = "SELECT * FROM gallery WHERE isDel='1'";
                // echo $select;
                $result = mysqli_query($con, $select);
                if (!$result == "") {
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 adv">
                            <div class="item">
                                <a href="#"><img src="admin/upload/<?php echo $row['image'] ?>"
                                        alt="<?php echo $row['image'] ?>"></a>
                                <span class="category">
                                    <?php echo $row["heading"] ?>
                                </span>
                                <h6>
                                    <?php echo $row["addedOn"] ?>
                                </h6>

                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>
        </div>
    </div>




    <footer>
        <div class="container">
            <div class="col-lg-8">
                <p>Copyright © 2048 Villa Agency Co., Ltd. All rights reserved.

                    Design: <a rel="nofollow" href="https://templatemo.com" target="_blank">TemplateMo</a> Distribution:
                    <a href="https://themewagon.com">ThemeWagon</a>
                </p>
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