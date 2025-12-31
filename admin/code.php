<?php
session_start();
include_once('../Includes/db.php');

$msg = $message = $_REQUEST['msg'];
echo $msg;

switch ($msg) {


    case 'logout':
        session_destroy();
        echo '<script>alert("Logout Successfully."); window.location.href = "../index.php";</script>';
        exit;

    case 'add-news':
        $file = $_FILES['file']['name'];
        $type = $_FILES['file']['type'];
        $size = $_FILES['file']['size'];
        $location = "../admin/upload/";
        $tmpname = $_FILES['file']['tmp_name'];
        // echo $file, "<br/>", $type, '<br/>', $size, '<br/>', $location, '<br/>', $tmpname, '<br/>'; 
        $title = $_POST["title"];
        // echo $title;
        $desc = $_POST["description"];
        // echo $desc;
        if ($file != null) {
            if ($type == "image/png" or $type == "image/jpeg" or $type == "image/jpg") {
                $query = "INSERT INTO news(title,file,description,isDel,addedOn) VALUES('" . $title . "','" . $file . "','" . $desc . "','true','" . date("Y-m-d") . "')";
                // echo $query, '<br/>';
                move_uploaded_file($tmpname, $location . $file);
                $result = mysqli_query($con, $query);
                if ($result) {
                    echo '<script>alert("Added Successfully."); window.location.href = "../admin/AddNews.php";</script>';
                    exit;
                } else {
                    echo '<script>alert("Not Added."); window.location.href = "../admin/AddNews.php";</script>';
                    exit;
                }
            }
        }
        break;

    case 'add-Gallery':
        $file = $_FILES['file']['name'];
        $type = $_FILES['file']['type'];
        $size = $_FILES['file']['size'];
        $location = "../admin/upload/";
        $tmpname = $_FILES['file']['tmp_name'];
        // echo $file, "<br/>", $type, '<br/>', $size, '<br/>', $location, '<br/>', $tmpname, '<br/>'; 
        if ($file != null) {
            if ($type == "image/png" or $type == "image/jpeg" or $type == "image/jpg") {
                $query = "INSERT INTO gallery( `heading`, `image`, `addedOn`, `isDel`) VALUES('" . $_POST["heading"] . "','" . $file . "','" . date("Y-m-d") . "','true')";
                // echo $query, '<br/>';
                move_uploaded_file($tmpname, $location . $file);
                $result = mysqli_query($con, $query);
                if ($result) {
                    echo '<script>alert("Added Successfully."); window.location.href = "../admin/AddGallery.php";</script>';
                    exit;
                } else {
                    echo '<script>alert("Not Added."); window.location.href = "../admin/AddGallery.php";</script>';
                    exit;
                }
            }
        }
        break;

    case 'add-slider':
        $file = $_FILES['file']['name'];
        $type = $_FILES['file']['type'];
        $size = $_FILES['file']['size'];
        $location = "../admin/upload/";
        $tmpname = $_FILES['file']['tmp_name'];
        // echo $file, "<br/>", $type, '<br/>', $size, '<br/>', $location, '<br/>', $tmpname, '<br/>'; 
        $title = $_POST["title"];
        // echo $title;
        $quots = $_POST["quots"];
        // echo $desc;
        if ($file != null) {
            if ($type == "image/png" or $type == "image/jpeg" or $type == "image/jpg") {
                $query = "INSERT INTO slider(`title`, `quots`, `file`, `addedOn`, `isDel`) VALUES('" . $title . "','" . $quots . "','" . $file . "','" . date("Y-m-d") . "','true')";
                // echo $query, '<br/>';
                move_uploaded_file($tmpname, $location . $file);
                $result = mysqli_query($con, $query);
                if ($result) {
                    echo '<script>alert("Added Successfully."); window.location.href = "../admin/AddSlider.php";</script>';
                    exit;
                } else {
                    echo '<script>alert("Not Added."); window.location.href = "../admin/AddSlider.php";</script>';
                    exit;
                }
            }
        }
        break;

    case 'change-password':
        $opwd = $_POST["old"];
        $npwd = $_POST["new"];
        $cnpwd = $_POST["cnew"];
        // echo $opwd, "<br/>", $npwd, '<br/>', $cnpwd, '<br/>';
        $select = "SELECT password FROM admin WHERE userId='" . $_SESSION["loginAdmin"] . "'";
        // echo $select;
        $result = mysqli_query($con, $select);
        while ($row = mysqli_fetch_array($result)) {
            $ppwd = $row['password'];
            // echo $ppwd;
        }
        if ($ppwd == $opwd) {
            if ($opwd != $npwd) {
                if ($npwd == $cnpwd) {
                    $update = "UPDATE admin SET password='" . $_POST["cnew"] . "' WHERE userId='" . $_SESSION["loginAdmin"] . "'";
                    // echo $update;
                    $result1 = mysqli_query($con, $update);
                    if ($result1) {
                        session_destroy();
                        echo '<script>alert("Password Changed."); window.location.href = "../index.php";</script>';
                        exit;
                    } else {
                        echo '<script>alert("Password Not Chnaged."); window.location.href = "../index.php";</script>';
                        exit;
                    }
                } else {
                    echo '<script>alert("new password are not matched with confirm password."); window.location.href = "../admin/ChangePassword.php";</script>';
                    exit;
                }
            } else {
                echo '<script>alert("old password are matched with new password."); window.location.href = "../admin/ChangePassword.php";</script>';
                exit;
            }
        } else {
            echo '<script>alert("old password are not matched with selected password."); window.location.href = "../admin/ChangePassword.php";</script>';

        }

        break;

    case 'delete-Contact':
        $id = $_REQUEST['id'];
        $deleteContact = "UPDATE contact SET isDel=0 where cid='" . $id . "'";
        // echo $deleteContact;
        $result = mysqli_query($con, $deleteContact);
        if ($result) {
            echo '<script>alert("Deleted Successfully."); window.location.href = "../admin/ContactManagement.php";</script>';

        } else {
            echo '<script>alert("Not Deleted."); window.location.href = "../admin/ContactManagement.php";</script>';

        }
        break;

    case 'delete-Volunteer':
        $id = $_REQUEST['id'];
        $deleteVounteer = "UPDATE vounteer SET isDel=0 where vId='" . $id . "'";
        // echo $deleteContact;
        $result = mysqli_query($con, $deleteVounteer);
        if ($result) {
            echo '<script>alert("Deleted Successfully."); window.location.href = "../admin/VolunteerManagement.php";</script>';

        } else {
            echo '<script>alert("Not Deleted."); window.location.href = "../admin/VolunteerManagement.php";</script>';

        }
        break;

    case 'delete-Donate':
        $id = $_REQUEST['id'];
        $deleteDonate = "UPDATE donate SET isDel=0 where dId='" . $id . "'";
        // echo $deleteContact;
        $result = mysqli_query($con, $deleteDonate);
        if ($result) {
            echo '<script>alert("Deleted Successfully."); window.location.href = "../admin/DonateManagement.php";</script>';

        } else {
            echo '<script>alert("Not Deleted."); window.location.href = "../admin/DonateManagement.php";</script>';

        }
        break;

    case 'delete-Gallery':
        $id = $_REQUEST['id'];
        $deleteGallery = "UPDATE gallery SET isDel=0 where gId='" . $id . "'";
        // echo $deleteContact;
        $result = mysqli_query($con, $deleteGallery);
        if ($result) {
            echo '<script>alert("Deleted Successfully."); window.location.href = "../admin/GalleryManagement.php";</script>';

        } else {
            echo '<script>alert("Not Deleted."); window.location.href = "../admin/GalleryManagement.php";</script>';

        }
        break;

    case 'delete-News':
        $id = $_REQUEST['id'];
        $deleteNews = "UPDATE news SET isDel=0 where nId='" . $id . "'";
        // echo $deleteContact;
        $result = mysqli_query($con, $deleteNews);
        if ($result) {
            echo '<script>alert("Deleted Successfully."); window.location.href = "../admin/NewsManagement.php";</script>';

        } else {
            echo '<script>alert("Not Deleted."); window.location.href = "../admin/NewsManagement.php";</script>';

        }
        break;

    case 'delete-Slider':
        $id = $_REQUEST['id'];
        $deleteSlider = "UPDATE slider SET isDel=0 where sId='" . $id . "'";
        // echo $deleteContact;
        $result = mysqli_query($con, $deleteSlider);
        if ($result) {
            echo '<script>alert("Deleted Successfully."); window.location.href = "../admin/SliderManagement.php";</script>';

        } else {
            echo '<script>alert("Not Deleted."); window.location.href = "../admin/SliderManagement.php";</script>';

        }
        break;
}
