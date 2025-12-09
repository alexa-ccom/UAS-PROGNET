<?php

include_once 'db-config.php';

class Cart extends Database {

    public function addToCart($userId, $productId, $quantity = 1)
    {
        // Cek dulu apakah produk sudah ada di keranjang user ini
        $checkQuery = "SELECT id_cart, prod_qty FROM tb_carts WHERE id_user = ? AND id_produk = ?";
        $checkStmt = $this->conn->prepare($checkQuery);

        if (!$checkStmt) {
            return ['status' => false, 'message' => 'Database error'];
        }

        $checkStmt->bind_param("ii", $userId, $productId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            // Sudah ada → update jumlah
            $row = $result->fetch_assoc();
            $newQty = $row['prod_qty'] + $quantity;

            $checkStmt->close();

            $updateQuery = "UPDATE tb_carts SET prod_qty = ? WHERE id_cart = ?";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bind_param("ii", $newQty, $row['id_cart']);

            $success = $updateStmt->execute();
            $updateStmt->close();

            return [
                'status' => $success,
                'message' => $success ? 'Jumlah produk di keranjang diperbarui' : 'Gagal memperbarui keranjang'
            ];
        } else {
            // Belum ada → insert baru
            $checkStmt->close();

            $insertQuery = "INSERT INTO tb_carts (id_user, id_produk, prod_qty) VALUES (?, ?, ?)";
            $insertStmt = $this->conn->prepare($insertQuery);

            if (!$insertStmt) {
                return ['status' => false, 'message' => 'Database error'];
            }

            $insertStmt->bind_param("iii", $userId, $productId, $quantity);
            $success = $insertStmt->execute();
            $insertStmt->close();

            return [
                'status' => $success,
                'message' => $success ? 'Produk berhasil ditambahkan ke keranjang' : 'Gagal menambah ke keranjang'
            ];
        }
    }


    //  UPDATE JUMLAH PRODUK DI CART
    public function updateQuantity($cartId, $userId, $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeFromCart($cartId, $userId); // otomatis hapus kalau qty ≤ 0
        }

        $query = "UPDATE tb_carts SET prod_qty = ? WHERE id_cart = ? AND id_user = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) return false;

        $stmt->bind_param("iii", $quantity, $cartId, $userId);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }


    //  HAPUS DARI KERANJANG
    public function removeFromCart($cartId, $userId)
    {
        $query = "DELETE FROM tb_carts WHERE id_cart = ? AND id_user = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) return false;

        $stmt->bind_param("ii", $cartId, $userId);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }


    //  AMBIL SEMUA ISI KERANJANG USER
    public function getUserCart($userId)
    {
        $query = "SELECT 
                    c.id_cart,
                    c.id_produk,
                    c.prod_qty,
                    p.nama_produk,
                    p.foto_produk AS gambar,
                    p.harga
                  FROM tb_carts c
                  JOIN tb_listing p ON c.id_produk = p.id_produk
                  WHERE c.id_user = ?
                  ORDER BY c.id_cart DESC";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) return [];

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $cart = [];
        while ($row = $result->fetch_assoc()) {
            $cart[] = $row;
        }

        $stmt->close();
        return $cart;
    }


    //  HITUNG JUMLAH ITEM DI KERANJANG
    public function getCartCount($userId)
    {
        $query = "SELECT COUNT(*) as total FROM tb_carts WHERE id_user = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return 0;

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();
        return (int)$row['total'];
    }


    //  TOTAL HARGA KERANJANG
    public function getCartTotalPrice($userId)
    {
        $query = "SELECT SUM(p.harga * c.prod_qty) as total 
                  FROM tb_carts c
                  JOIN tb_listing p ON c.id_produk = p.id_produk
                  WHERE c.id_user = ?";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) return 0;

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();
        return $row['total'] ?? 0;
    }

}