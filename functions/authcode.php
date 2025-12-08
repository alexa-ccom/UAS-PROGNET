<?php

session_start();
include('../config/db-config.php');
include('reuseableFunction.php');

if (isset($_POST['register_btn'])) {

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

    // Email Check
    $check_email_query = "SELECT email FROM tb_user WHERE email='$email' ";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if (mysqli_num_rows($check_email_query_run) > 0) {

        redirect("../register.php", "Email already registered");

    } else {

        if ($password == $cpassword) {
    
            $query = "INSERT INTO tb_user (nama_user, email, no_telp, password) VALUES ('$name', '$email', '$phone', '$password' )";
    
            $insert_query_run = mysqli_query($con, $query);
    
            if ($insert_query_run) {
                redirect("../login.php", "Registered Successfully");


            } else {
                redirect("../register.php", "Something went wrong");

            }
            
        } else {
            redirect("../register.php", "Passwords do not match");

        }

    }



}

else if (isset($_POST['login_btn'])) {
    
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $login_query = "SELECT * FROM tb_user WHERE email='$email' AND password='$password' ";
    $login_query_run = mysqli_query($con, $login_query);

    if (mysqli_num_rows($login_query_run) > 0) {

        $_SESSION['auth'] = true;

        $userdata = mysqli_fetch_array($login_query_run);
        $userid = $userdata['id_user'];
        $username = $userdata['nama_user'];
        $useremail = $userdata['email'];
        $role = $userdata['role'];

        $_SESSION['auth_user'] = [
            'id_user' => $userid,
            'nama_user' => $username,
            'email' => $useremail
        ];

        $_SESSION['role'] = $role;

        // LOGIN ADMIN FUNCTION
        if ($role == 1) {

            redirect("../admin/index.php", "Welcome To Admin Dashboard");

        } else {

            redirect("../index.php", "Logged In Successfully");

        }



    } else {

        redirect("../login.php", "Invalid Credentials");

    }
}
?>