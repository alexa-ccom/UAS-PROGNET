<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!class_exists('Database')) {

    class Database {
        private $host = "localhost";
        private $username = "root";
        private $password = "";
        private $database = "db_ecom";
        protected $conn;

        public function __construct() {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            if ($this->conn->connect_error) {
                die("Connection Failed: " . $this->conn->connect_error);
            }
            $this->conn->set_charset("utf8");
        }

        public function getConnection() {
            return $this->conn;
        }

    }
}

if (!isset($GLOBALS['db_instance'])) {
    $GLOBALS['db_instance'] = new Database();
}

$con = $GLOBALS['db_instance']->getConnection();
$GLOBALS['con'] = $con;  
?>