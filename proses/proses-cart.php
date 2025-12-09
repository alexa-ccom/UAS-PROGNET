<?php
session_start();
header('Content-Type: application/json');

include_once __DIR__ . '/../config/db-config.php';
include_once __DIR__ . '/../config/class-cart.php';


if (!isset($_SESSION['auth'])) {
    echo json_encode(['status' => 401, 'message' => 'Login dulu bro']);
    exit;
}

$userId = $_SESSION['auth_user']['id_user'];
$cart   = new Cart(); // otomatis koneksi dari parent Database

$scope = $_POST['scope'] ?? '';

switch ($scope) {
    case 'add':
        $prod_id = (int)$_POST['id_produk'];
        $qty     = (int)($_POST['prod_qty'] ?? 1);

        $result = $cart->addToCart($userId, $prod_id, $qty);
        echo json_encode([
            'status'  => $result['status'] ? 201 : 500,
            'message' => $result['message']
        ]);
        break;

    case 'update':
        $cart_id = (int)$_POST['id_cart'];
        $qty     = (int)$_POST['prod_qty'];

        $success = $cart->updateQuantity($cart_id, $userId, $qty);

        echo json_encode([
            'status' => $success ? 200 : 500,
            'message' => $success ? 'Updated' : 'Failed'
        ]);
        break;

    case 'delete':
        $cart_id = (int)$_POST['id_cart'];
        $success = $cart->removeFromCart($cart_id, $userId);

        echo json_encode([
            'status'  => $success ? 200 : 500,
            'message' => $success ? 'Produk dihapus dari keranjang' : 'Gagal menghapus'
        ]);
        break;

    default:
        echo json_encode(['status' => 400, 'message' => 'Aksi tidak dikenali']);
}