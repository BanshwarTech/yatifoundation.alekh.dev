<div class="sub-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <ul class="info">

                </ul>
            </div>
            <div class="col-lg-4 col-md-4">
                <ul class="social-links">
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background-color:#F35525;color:white">
                        Admin Login
                    </button>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Admin Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="Includes/code.php?msg=login" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                    </div>
                    <button type="submit" class="btn " style="background-color:#F35525;color:white" name="btnlogin">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ***** Header Area Start ***** -->
<div class="container">
    <div class="col-sm-12">
        <nav class="navbar navbar-expand-lg navbar-light ">
            <div class="container-fluid">
                <div class="col-sm-3">
                    <a class="navbar-brand" href="index.php" style="color:#F35525;font-family: algerian;">Yati Foundation</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="col-sm-9">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="AboutUs.php">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Vounteer.php">Vounteer</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Donate.php">Donate</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Gallery.php">Gallery</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="ContactUs.php">Contact Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="News.php">News</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </nav>
    </div>
</div>