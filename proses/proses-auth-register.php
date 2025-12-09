<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../config/class-auth.php');
include('../functions/reuseableFunction.php');

$auth = new Auth();

if (isset($_POST['register_btn'])) {

    $dataRegister = [
        'name' => $_POST['name'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? '',
        'cpassword' => $_POST['cpassword'] ?? ''
    ];

    $result = $auth->register($dataRegister);

    if($result['status']){
        redirect("../login.php", $result['message']);
    } else {
        redirect("../register.php", $result['message']);
    }

}

?>