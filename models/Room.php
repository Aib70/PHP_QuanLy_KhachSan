<?php
class Room {
    private $conn;
    private $table_name = "Rooms";

    public $room_id;
    public $room_number;
    public $type_id;
    public $status;
    public $image; // <--- 1. Mới thêm thuộc tính này để chứa tên file ảnh

    // Thuộc tính bổ sung để hiển thị
    public $type_name;
    public $price;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Đọc tất cả phòng (Có lấy thêm cột image)
    public function readAll() {
        // Thêm r.image vào câu truy vấn
        $query = "SELECT r.room_id, r.room_number, r.status, r.image, t.type_name, t.price_per_night 
                  FROM " . $this->table_name . " r
                  LEFT JOIN RoomTypes t ON r.type_id = t.type_id
                  ORDER BY r.room_id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 2. Lấy danh sách Loại phòng
    public function readRoomTypes() {
        $query = "SELECT * FROM RoomTypes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 3. Thêm phòng mới (CÓ LƯU ẢNH)
    public function create() {
        // Thêm image=:image vào query insert
        $query = "INSERT INTO " . $this->table_name . " 
                  SET room_number=:room_number, type_id=:type_id, status=:status, image=:image";
        
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->room_number = htmlspecialchars(strip_tags($this->room_number));
        $this->type_id = htmlspecialchars(strip_tags($this->type_id));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->image = htmlspecialchars(strip_tags($this->image)); // <--- Xử lý ảnh

        // Gán dữ liệu vào query
        $stmt->bindParam(":room_number", $this->room_number);
        $stmt->bindParam(":type_id", $this->type_id);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":image", $this->image); // <--- Bind tham số ảnh

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // 4. Lấy thông tin 1 phòng theo ID (Để sửa)
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE room_id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->room_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Gán giá trị vào các thuộc tính của object
        if($row) {
            $this->room_number = $row['room_number'];
            $this->type_id = $row['type_id'];
            $this->status = $row['status'];
            // Lấy ảnh, nếu null thì gán mặc định
            $this->image = isset($row['image']) ? $row['image'] : 'default.jpg'; 
        }
    }

    // 5. Cập nhật phòng (CÓ CẬP NHẬT ẢNH)
    public function update() {
        // Thêm image=:image vào query update
        $query = "UPDATE " . $this->table_name . "
                  SET room_number = :room_number,
                      type_id = :type_id,
                      status = :status,
                      image = :image 
                  WHERE room_id = :room_id";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->room_number = htmlspecialchars(strip_tags($this->room_number));
        $this->type_id = htmlspecialchars(strip_tags($this->type_id));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->image = htmlspecialchars(strip_tags($this->image)); // <--- Xử lý ảnh
        $this->room_id = htmlspecialchars(strip_tags($this->room_id));

        // Gán dữ liệu
        $stmt->bindParam(':room_number', $this->room_number);
        $stmt->bindParam(':type_id', $this->type_id);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':image', $this->image); // <--- Bind tham số ảnh
        $stmt->bindParam(':room_id', $this->room_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // 6. Xóa phòng
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE room_id = ?";
        $stmt = $this->conn->prepare($query);
        
        $this->room_id = htmlspecialchars(strip_tags($this->room_id));
        $stmt->bindParam(1, $this->room_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    // ... (Giữ nguyên các hàm cũ) ...

    // 7. Tìm kiếm phòng (Theo tên loại phòng hoặc số phòng)
    public function search($keyword) {
        // Tìm những phòng có Tên loại chứa từ khóa HOẶC Số phòng chứa từ khóa
        // VÀ trạng thái phải là Available (Trống)
        $query = "SELECT r.room_id, r.room_number, r.status, r.image, t.type_name, t.price_per_night 
                  FROM " . $this->table_name . " r
                  LEFT JOIN RoomTypes t ON r.type_id = t.type_id
                  WHERE (t.type_name LIKE ? OR r.room_number LIKE ?) 
                  AND r.status = 'Available'
                  ORDER BY r.room_id ASC";

        $stmt = $this->conn->prepare($query);

        // Thêm dấu % để tìm kiếm gần đúng (VD: gõ "VIP" sẽ tìm thấy "Phòng VIP")
        $keyword = "%{$keyword}%";

        $stmt->bindParam(1, $keyword);
        $stmt->bindParam(2, $keyword);

        $stmt->execute();
        return $stmt;
    }
    // hàm cập nhật trạng thái phòng nhanh.
    public function updateStatusOnly($room_id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE room_id = :room_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':room_id', $room_id);
        return $stmt->execute();
    }
}
?>