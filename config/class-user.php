<?php 

include_once 'db-config.php';


class User extends Database {

    // Method untuk fetch all data yang active (status = 0)
    public function getAllActive($table){
        // Validasi nama tabel untuk keamanan
        $allowedTables = ['tb_produk', 'tb_kategori', 'tb_user', 'tb_orders'];
        
        if(!in_array($table, $allowedTables)){
            return [];
        }

        $query = "SELECT * FROM $table WHERE status = '0'";
        $result = $this->conn->query($query);
        
        $data = [];
        if($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        }
        
        return $data;
    }

    // Method untuk get data by slug yang active
    public function getSlugActive($table, $slug){
        // Validasi nama tabel
        $allowedTables = ['tb_produk', 'tb_kategori'];
        
        if(!in_array($table, $allowedTables)){
            return null;
        }

        $query = "SELECT * FROM $table WHERE slug = ? AND status = '0' LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        if(!$stmt){
            return null;
        }

        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = null;
        if($result->num_rows > 0){
            $data = $result->fetch_assoc();
        }
        
        $stmt->close();
        return $data;
    }

    // Method untuk get produk by category
    public function getProductByCategory($categoryId){
        $query = "SELECT * FROM tb_produk WHERE id_kategori = ? AND status = '0' ORDER BY id_produk DESC";
        $stmt = $this->conn->prepare($query);
        
        if(!$stmt){
            return [];
        }

        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $products = [];
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $products[] = $row;
            }
        }
        
        $stmt->close();
        return $products;
    }

    // Method untuk get cart user (butuh userId dari session)
    public function getCart($userId){
        $query = "SELECT 
                    c.id_cart AS cid, 
                    c.id_produk, 
                    c.prod_qty, 
                    p.id_produk AS pid, 
                    p.nama_produk, 
                    p.gambar, 
                    p.harga_jual
                  FROM tb_carts c
                  JOIN tb_produk p ON c.id_produk = p.id_produk
                  WHERE c.id_user = ?
                  ORDER BY c.id_cart DESC";
        
        $stmt = $this->conn->prepare($query);
        
        if(!$stmt){
            return [];
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $cart = [];
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $cart[] = $row;
            }
        }
        
        $stmt->close();
        return $cart;
    }

    // Method untuk get orders user
    public function getOrders($userId){
        $query = "SELECT * FROM tb_orders WHERE id_user = ? ORDER BY id_order DESC";
        $stmt = $this->conn->prepare($query);
        
        if(!$stmt){
            return [];
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $orders = [];
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $orders[] = $row;
            }
        }
        
        $stmt->close();
        return $orders;
    }

    // Method untuk get profile user
    public function getProfile($userId){
        $query = "SELECT * FROM tb_user WHERE id_user = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        if(!$stmt){
            return null;
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $profile = null;
        if($result->num_rows > 0){
            $profile = $result->fetch_assoc();
        }
        
        $stmt->close();
        return $profile;
    }

    // Method untuk get trending products (popularitas = 1)
    public function getTrending(){
        $query = "SELECT * FROM tb_produk WHERE popularitas = '1'";
        $result = $this->conn->query($query);
        
        $trending = [];
        if($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $trending[] = $row;
            }
        }
        
        return $trending;
    }

    // BONUS: Method untuk get cart count
    public function getCartCount($userId){
        $query = "SELECT COUNT(*) as total FROM tb_carts WHERE id_user = ?";
        $stmt = $this->conn->prepare($query);
        
        if(!$stmt){
            return 0;
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $count = 0;
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $count = $row['total'];
        }
        
        $stmt->close();
        return $count;
    }

    // Method untuk calculate cart total
    public function getCartTotal($userId){
        $query = "SELECT SUM(p.harga_jual * c.prod_qty) as total
                  FROM tb_carts c
                  JOIN tb_produk p ON c.id_produk = p.id_produk
                  WHERE c.id_user = ?";
        
        $stmt = $this->conn->prepare($query);
        
        if(!$stmt){
            return 0;
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $total = 0;
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $total = $row['total'] ?? 0;
        }
        
        $stmt->close();
        return $total;
    }

    // Method untuk add to cart
    public function addToCart($userId, $productId, $quantity = 1){
        // Cek apakah produk sudah ada di cart
        $checkQuery = "SELECT * FROM tb_carts WHERE id_user = ? AND id_produk = ?";
        $checkStmt = $this->conn->prepare($checkQuery);
        
        if(!$checkStmt){
            return [
                'status' => false,
                'message' => 'Failed to add to cart'
            ];
        }

        $checkStmt->bind_param("ii", $userId, $productId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if($checkResult->num_rows > 0){
            // Update quantity jika sudah ada
            $checkStmt->close();
            
            $updateQuery = "UPDATE tb_carts SET prod_qty = prod_qty + ? WHERE id_user = ? AND id_produk = ?";
            $updateStmt = $this->conn->prepare($updateQuery);
            
            if(!$updateStmt){
                return [
                    'status' => false,
                    'message' => 'Failed to update cart'
                ];
            }

            $updateStmt->bind_param("iii", $quantity, $userId, $productId);
            $result = $updateStmt->execute();
            $updateStmt->close();

            return [
                'status' => $result,
                'message' => $result ? 'Cart updated successfully' : 'Failed to update cart'
            ];
        } else {
            // Insert baru jika belum ada
            $checkStmt->close();
            
            $insertQuery = "INSERT INTO tb_carts (id_user, id_produk, prod_qty) VALUES (?, ?, ?)";
            $insertStmt = $this->conn->prepare($insertQuery);
            
            if(!$insertStmt){
                return [
                    'status' => false,
                    'message' => 'Failed to add to cart'
                ];
            }

            $insertStmt->bind_param("iii", $userId, $productId, $quantity);
            $result = $insertStmt->execute();
            $insertStmt->close();

            return [
                'status' => $result,
                'message' => $result ? 'Product added to cart' : 'Failed to add to cart'
            ];
        }
    }

    // Method untuk remove from cart
    public function removeFromCart($userId, $cartId){
        $query = "DELETE FROM tb_carts WHERE id_cart = ? AND id_user = ?";
        $stmt = $this->conn->prepare($query);
        
        if(!$stmt){
            return false;
        }

        $stmt->bind_param("ii", $cartId, $userId);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // BONUS: Method untuk update cart quantity
    public function updateCartQty($userId, $cartId, $quantity){
        if($quantity <= 0){
            return $this->removeFromCart($userId, $cartId);
        }

        $query = "UPDATE tb_carts SET prod_qty = ? WHERE id_cart = ? AND id_user = ?";
        $stmt = $this->conn->prepare($query);
        
        if(!$stmt){
            return false;
        }

        $stmt->bind_param("iii", $quantity, $cartId, $userId);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

        // 1. Ambil data order berdasarkan tracking number
public function getOrderByTracking($tracking_no, $userId) {

    $query = "SELECT 
                o.*,
                a.alamat AS alamat_lengkap,
                a.kota,
                a.provinsi
              FROM tb_orders o
              JOIN tb_alamat a ON o.alamat = a.id_alamat
              WHERE o.no_tracking = ? AND o.id_user = ?
              LIMIT 1";

    $stmt = $this->conn->prepare($query);
    if (!$stmt) return false;

    $stmt->bind_param("si", $tracking_no, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = $result->fetch_assoc();
    $stmt->close();

    return $data ?: false;
}


    //  Ambil semua item dari order (INI YANG DIPERBAIKI)
    public function getOrderItemsByTracking($tracking_no, $userId) {
        $query = "SELECT 
                    oi.qty, 
                    oi.harga,
                    p.id_produk, 
                    p.nama_produk, 
                    p.gambar
                  FROM order_items oi
                  JOIN tb_orders o ON oi.id_order = o.id_order
                  JOIN tb_produk p ON p.id_produk = oi.id_produk
                  WHERE o.no_tracking = ? AND o.id_user = ?
                  ORDER BY oi.id_order ASC";  
                  
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return [];

        $stmt->bind_param("si", $tracking_no, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        $stmt->close();
        return $items;
    }

}

?>