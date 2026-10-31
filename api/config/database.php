<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        // Dynamic fallback: Use remote credentials on InfinityFree, else use local Termux
        if (isset($_SERVER['HTTP_HOST']) && strstr($_SERVER['HTTP_HOST'], 'infinityfreeapp.com')) {
            $this->host = 'sql202.infinityfree.com';
            $this->db_name = 'if0_43321284_barangay_db';
            $this->username = 'if0_43321284';
            $this->password = 'Wywqgqp3dNzKB'; // Replace with your actual hosting password
        } else {
            $this->host = 'localhost';
            $this->db_name = 'barangay_db';
            $this->username = 'root';
            $this->password = '';
        }

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
