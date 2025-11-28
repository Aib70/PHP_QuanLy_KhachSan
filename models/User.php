<?php
class User {
    private $conn;
    private $table = "Users";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Hàm Login (Giữ nguyên)
    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($password == $row['password']) {
                return $row;
            }
        }
        return false;
    }

    // 2. Hàm kiểm tra Username tồn tại (Cần cho Đăng ký)
    public function checkUsernameExists($username) {
        $query = "SELECT user_id FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true; // Đã tồn tại
        }
        return false; // Chưa tồn tại
    }

    // 3. Hàm Đăng ký (Lưu vào CSDL)
    public function register($username, $password, $full_name) {
        $query = "INSERT INTO " . $this->table . " 
                  SET username = :username, 
                      password = :password, 
                      full_name = :full_name, 
                      role = 'guest'"; // Mặc định là khách

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $username = htmlspecialchars(strip_tags($username));
        $full_name = htmlspecialchars(strip_tags($full_name));
        $password = htmlspecialchars(strip_tags($password));

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':full_name', $full_name);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>