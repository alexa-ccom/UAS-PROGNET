<?php
session_start();
include('../config/db-config.php');
include('reuseableFunction.php');

header('Content-Type: application/json');

if (isset($_SESSION['auth'])) {

    if (isset($_POST['placeOrderBtn'])) {

        $name = mysqli_real_escape_string($con, $_POST['nama_user']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $phone = mysqli_real_escape_string($con, $_POST['no_telp']);
        $pincode = mysqli_real_escape_string($con, $_POST['pincode']);
        $address = mysqli_real_escape_string($con, $_POST['alamat']);

        if ($name == "" || $email == "" || $phone == "" || $pincode == "" || $address == "") {
            
            redirect("../checkout.php", "Please enter the fields");
        }

    }
} else {
    redirect("../login.php", "Please login");

}
?>