<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../config/class-auth.php');
include('../functions/reuseableFunction.php');

$auth = new Auth();

if (isset($_POST['login_btn'])) {
    
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = $auth->login($email, $password);

    if($result['status']){
        
        // Set session
        $_SESSION['auth'] = true;
        $_SESSION['auth_user'] = [
            'id_user' => $result['data']['id_user'],
            'nama_user' => $result['data']['nama_user'],
            'email' => $result['data']['email']
        ];
        $_SESSION['role'] = $result['data']['role'];

        // Redirect based on role
        if($result['data']['role'] == 1){
            redirect("../admin/index.php", "Welcome To Admin Dashboard");
        } else {
            redirect("../index.php", "Logged In Successfully");
        }

    } else {
        redirect("../login.php", $result['message']);
    }

}
?>