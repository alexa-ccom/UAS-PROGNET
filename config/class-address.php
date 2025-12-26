<?php

include_once 'db-config.php';

class Address extends Database {

    public function addAddress($user_id, $alamat, $kota, $provinsi){

        $query = "INSERT INTO tb_alamat (id_user, alamat, kota, provinsi)
                  VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isss", $user_id, $alamat, $kota, $provinsi);

        return $stmt->execute();
    }

    public function getAddressByUser($user_id){
        $query = "SELECT * FROM tb_alamat WHERE id_user = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function deleteAddress($alamat_id, $user_id){
        $query = "DELETE FROM tb_alamat WHERE id_alamat = ? AND id_user = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $alamat_id, $user_id);

        return $stmt->execute();
    }
}
