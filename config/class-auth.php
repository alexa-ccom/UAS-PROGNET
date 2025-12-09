<?php 

include_once 'db-config.php';

class Auth extends Database {

    // Method untuk cek apakah email sudah terdaftar
    public function isEmailExist($email){
        $query = "SELECT email FROM tb_user WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        
        if(!$stmt){
            return false;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $exists = $result->num_rows > 0;
        $stmt->close();
        
        return $exists;
    }

    // Method untuk register user baru
    public function register($data){
        $name = $data['name'];
        $phone = $data['phone'];
        $email = $data['email'];
        $password = $data['password'];
        $cpassword = $data['cpassword'];

        // Cek apakah email sudah ada
        if($this->isEmailExist($email)){
            return [
                'status' => false,
                'message' => 'Email already registered'
            ];
        }

        // Cek apakah password cocok
        if($password != $cpassword){
            return [
                'status' => false,
                'message' => 'Passwords do not match'
            ];
        }

        // Hash password (lebih aman)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user baru
        $query = "INSERT INTO tb_user (nama_user, email, no_telp, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        
        if(!$stmt){
            return [
                'status' => false,
                'message' => 'Something went wrong'
            ];
        }

        $stmt->bind_param("ssss", $name, $email, $phone, $hashedPassword);
        $result = $stmt->execute();
        $stmt->close();

        if($result){
            return [
                'status' => true,
                'message' => 'Registered Successfully'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Something went wrong'
            ];
        }
    }

    // Method untuk login
    public function login($email, $password){
        $query = "SELECT * FROM tb_user WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        
        if(!$stmt){
            return [
                'status' => false,
                'message' => 'Something went wrong'
            ];
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $userdata = $result->fetch_assoc();
            
            // Verifikasi password dengan password_verify (untuk password yang di-hash)
            if(password_verify($password, $userdata['password'])){
                $stmt->close();
                
                return [
                    'status' => true,
                    'message' => 'Login Success',
                    'data' => [
                        'id_user' => $userdata['id_user'],
                        'nama_user' => $userdata['nama_user'],
                        'email' => $userdata['email'],
                        'role' => $userdata['role']
                    ]
                ];
            } else {
                $stmt->close();
                return [
                    'status' => false,
                    'message' => 'Invalid Credentials'
                ];
            }
        } else {
            $stmt->close();
            return [
                'status' => false,
                'message' => 'Invalid Credentials'
            ];
        }
    }

}

?>