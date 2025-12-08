<?php
session_start();
include('../config/db-config.php');
include('reuseableFunction.php');

header('Content-Type: application/json');

if (isset($_SESSION['auth'])) {
    if (isset($_POST['scope'])) {
        $scope = $_POST['scope'];
        
        switch ($scope) {
            case 'add':
                $prod_id = mysqli_real_escape_string($con, $_POST['id_produk']);
                $prod_qty = mysqli_real_escape_string($con, $_POST['prod_qty']);
                $user_id = $_SESSION['auth_user']['id_user'];

                $check_existing_cart = "SELECT * FROM tb_carts WHERE id_produk='$prod_id' AND id_user='$user_id'";
                $check_existing_cart_run = mysqli_query($con, $check_existing_cart);

                if (mysqli_num_rows($check_existing_cart_run) > 0) {
                        echo json_encode(['status' => 500, 'message' => 'Product already at the cart']);
                } else {

                    $insert_query = "INSERT INTO tb_carts (id_user, id_produk, prod_qty) VALUES ('$user_id', '$prod_id', '$prod_qty')";
                    $insert_query_run = mysqli_query($con, $insert_query);
                    
                    if ($insert_query_run) {
                        echo json_encode(['status' => 201, 'message' => 'Product added to cart!']);
                    } else {
                        echo json_encode(['status' => 500, 'message' => 'Failed to add product']);
                    }

                }
                
                break;
                
            default:
                echo json_encode(['status' => 500, 'message' => 'Invalid action']);
        }
    }
} else {
    echo json_encode(['status' => 401, 'message' => 'Please login to continue']);
}
?>