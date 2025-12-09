<?php
session_start();

include_once __DIR__ . '/../config/db-config.php';
include_once __DIR__ . '/../config/class-user.php';
include('../functions/reuseableFunction.php');


if (!isset($_SESSION['auth'])) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_POST['placeOrderBtn'])) {
    header('Location: ../checkout.php');
    exit;
}

// Ambil data dari form
$userId   = $_SESSION['auth_user']['id_user'];
$nama     = trim($_POST['nama_user']);
$email    = trim($_POST['email']);
$phone    = trim($_POST['no_telp']);
$pincode  = trim($_POST['pincode']);
$alamat   = trim($_POST['alamat']);
$total    = (int)$_POST['total_price'];

// Validasi
if (empty($nama) || empty($email) || empty($phone) || empty($alamat) || $total <= 0) {
    $_SESSION['message'] = "Harap isi semua data dengan benar!";
    header('Location: ../checkout.php');
    exit;
}

// Pakai $con yang sudah dibuat di db-config.php
global $con;

$user = new User();
$cartItems = $user->getCart($userId);

if (empty($cartItems)) {
    $_SESSION['message'] = "Keranjang kosong!";
    header('Location: ../checkout.php');
    exit;
}

// Buat nomor tracking unik
$tracking_no = "ORD" . date("Ymd") . rand(100,999);

// 1. Simpan pesanan utama
$stmt = $con->prepare("INSERT INTO tb_orders 
    (id_user, no_tracking, nama_user, email, no_telp, alamat, pincode, total_harga, payment_mode, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'COD', 0)");

$stmt->bind_param("issssssi", $userId, $tracking_no, $nama, $email, $phone, $alamat, $pincode, $total);

if (!$stmt->execute()) {
    $_SESSION['message'] = "Gagal menyimpan pesanan. Coba lagi.";
    header('Location: ../checkout.php');
    exit;
}

$order_id = $con->insert_id;
$stmt->close();

foreach ($cartItems as $item) {
    $stmt2 = $con->prepare("INSERT INTO order_items (id_order, id_produk, qty, harga) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("iiii", $order_id, $item['id_produk'], $item['prod_qty'], $item['harga_jual']);
    $stmt2->execute();
    $stmt2->close();
}

$_SESSION['message'] = "Pesanan berhasil dibuat! Nomor tracking: <strong>$tracking_no</strong>";
header("Location: ../profile.php");
exit;
?>