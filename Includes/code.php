<?php
session_start();
include_once('db.php');
$message = "Email Or Password Does Not Match";

$msg = $message = $_REQUEST['msg'];
// echo $msg;

switch ($msg) {
    case "login":

        if (isset($_POST['btnlogin'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];
            echo $email;
            echo $password;

            $select = "select * from admin where userId='$email' and password='$password'";

            $result = mysqli_query($con, $select);

            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {

                    if ($row['usertype'] == "admin" and $row['isDel'] == 1) {

                        $_SESSION['loginAdmin'] = $row['userId'];
                        header('Location: ../admin/index.php');
                    }
                }
            } else {
                echo '<script>alert("Please enter correct email and password.");';
                echo 'window.location.href = "index.php";';
                echo '</script>';
                exit;
            }
        }
        break;


    case 'add-volunteer':
        $file = $_FILES['profile']['name'];
        $type = $_FILES['profile']['type'];
        $size = $_FILES['profile']['size'];
        $location = "../admin/upload/";
        $tmpname = $_FILES['profile']['tmp_name'];
        echo $file, "<br/>", $type, '<br/>', $size, '<br/>', $location, '<br/>', $tmpname, '<br/>';
        if (isset($_POST['btnVounteer'])) {
            if ($file != null) {
                if ($type == "image/png" or $type == "image/jpeg" or $type == "image/jpg") {
                    $query = "INSERT INTO vounteer (`name`, `email`, `mobile`, `profile`, `address`, `addedOn`, `gender`, `isDel`) VALUES('" . $_POST["name"] . "','" . $_POST["email"] . "','" . $_POST["mobile"] . "','" . $file . "','" . $_POST["address"] . "','" . date("Y-m-d") . "','" . $_POST["gender"] . "','true')";
                    echo $query;
                    move_uploaded_file($tmpname, $location . $file);
                    $result = mysqli_query($con, $query);
                    if ($result) {
                        echo '<script>alert("Added Successfully.");';
                        echo 'window.location.href = "../Vounteer.php";';
                        echo '</script>';
                        exit;
                    } else {
                        echo '<script>alert("Not Added.");';
                        echo 'window.location.href = "../Vounteer.php";';
                        echo '</script>';
                        exit;
                    }
                }
            }
        }

        break;

    case 'add-donate':
        if (isset($_POST['btnDonate'])) {
            $amount = $_POST["amount"];
            $amountDecimal = number_format($amount / 100, 2);
            echo $amountDecimal;
            $query = "INSERT INTO donate ( `name`, `mobile`, `email`, `amount`, `purposeofDonation`, `address`, `addedOn`, `isDel`) VALUES('" . $_POST["name"] . "','" . $_POST["mobile"] . "','" . $_POST["email"] . "','" . $amountDecimal . "','" . $_POST["donation"] . "','" . $_POST["address"] . "','" . date("Y-m-d") . "','true')";
            echo $query;
            $result = mysqli_query($con, $query);
            if ($result) {
                echo '<script>alert("Added Successfully.");';
                echo 'window.location.href = "../Donate.php";';
                echo '</script>';
                exit;
            } else {
                echo '<script>alert("Not Added.");';
                echo 'window.location.href = "../Donate.php";';
                echo '</script>';
                exit;
            }
        }

        break;

    case 'add-contact':
        if (isset($_POST['btnContact'])) {
            $query = "INSERT INTO contact ( `name`, `email`, `subject`, `message`, `addedOn`, `isDel`) VALUES('" . $_POST["name"] . "','" . $_POST["email"] . "','" . $_POST["subject"] . "','" . $_POST["message"] . "','" . date("Y-m-d") . "','true')";
            echo $query;
            $result = mysqli_query($con, $query);
            if ($result) {
                echo '<script>alert("Added Successfully.");';
                echo 'window.location.href = "../ContactUs.php";';
                echo '</script>';
                exit;
            } else {
                echo '<script>alert("Not Added.");';
                echo 'window.location.href = "../ContactUs.php";';
                echo '</script>';
                exit;
            }
        }

        break;
}
