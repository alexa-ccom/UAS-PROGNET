<?php
session_start();
require_once '../config/class-address.php';

$address = new Address();
$user_id = $_SESSION['auth_user']['id_user'];

// ADD
if (isset($_POST['add_address'])) {

    $alamat   = $_POST['alamat'];
    $kota     = $_POST['kota'];
    $provinsi = $_POST['provinsi'];

    if ($address->addAddress($user_id, $alamat, $kota, $provinsi)) {
        $_SESSION['message'] = "Alamat berhasil ditambahkan";
    } else {
        $_SESSION['message'] = "Gagal menambahkan alamat";
    }

    header("Location: ../add-address.php");
    exit();
}

// DELETE
if (isset($_POST['delete_address'])) {

    $alamat_id = $_POST['alamat_id'];

    if ($address->deleteAddress($alamat_id, $user_id)) {
        $_SESSION['message'] = "Alamat berhasil dihapus";
    } else {
        $_SESSION['message'] = "Gagal menghapus alamat";
    }

    header("Location: ../add-address.php");
    exit();
}
