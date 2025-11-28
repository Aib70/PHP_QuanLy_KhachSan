<?php
class Database {
    private $host = "localhost";
    private $db_name = "khachsan1"; // Tên CSDL bạn đã tạo ở bước trước
    private $username = "root"; // Mặc định của XAMPP
    private $password = "123456";     // Mặc định của XAMPP thường để trống
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Lỗi kết nối: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>