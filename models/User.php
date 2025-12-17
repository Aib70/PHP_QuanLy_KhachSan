<?php
class User {
    private $conn;
    private $table = "Users";

    public $user_id;
    public $username;
    public $password;
    public $full_name;
    public $role;
    
    // THUỘC TÍNH MỚI
    public $email;
    public $phone;
    public $position;

    public function __construct($db) {
        $this->conn = $db;
    }

    // --- AUTH (Giữ nguyên) ---
    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($password == $row['password']) return $row;
        }
        return false;
    }

    public function checkUsernameExists($username) {
        $query = "SELECT user_id FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function register($username, $password, $full_name) {
        $query = "INSERT INTO " . $this->table . " SET username=:u, password=:p, full_name=:f, role='guest'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':u', $username);
        $stmt->bindParam(':p', $password);
        $stmt->bindParam(':f', $full_name);
        return $stmt->execute();
    }

    // --- QUẢN LÝ NHÂN VIÊN (CẬP NHẬT) ---

    public function readAllStaff() {
        $query = "SELECT * FROM " . $this->table . " WHERE role = 'staff' ORDER BY user_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->user_id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->username = $row['username'];
            $this->full_name = $row['full_name'];
            $this->role = $row['role'];
            $this->password = $row['password'];
            // Lấy dữ liệu mới
            $this->email = $row['email'];
            $this->phone = $row['phone'];
            $this->position = $row['position'];
            return true;
        }
        return false;
    }

    // Thêm nhân viên (CÓ EMAIL, PHONE, POSITION)
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET username=:username, password=:password, full_name=:full_name, 
                      email=:email, phone=:phone, position=:position, role='staff'";
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->position = htmlspecialchars(strip_tags($this->position));

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':full_name', $this->full_name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':position', $this->position);

        return $stmt->execute();
    }

    // Cập nhật nhân viên
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET full_name=:full_name, password=:password,
                      email=:email, phone=:phone, position=:position
                  WHERE user_id=:user_id";
        $stmt = $this->conn->prepare($query);

        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->position = htmlspecialchars(strip_tags($this->position));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(':full_name', $this->full_name);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':position', $this->position);
        $stmt->bindParam(':user_id', $this->user_id);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->user_id);
        return $stmt->execute();
    }
}
?>