<?php
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../models/Room.php';

class RoomController {
    private $db;
    private $room;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->room = new Room($this->db);
    }

    // Hiển thị danh sách phòng
   public function index() {
        $stmt = $this->room->readAll();
        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // --- THÊM ĐOẠN NÀY ĐỂ THỐNG KÊ ---
        $count_available = 0;
        $count_booked = 0;
        $count_cleaning = 0;

        foreach($rooms as $r) {
            if($r['status'] == 'Available') $count_available++;
            elseif($r['status'] == 'Booked') $count_booked++;
            elseif($r['status'] == 'Cleaning') $count_cleaning++;
        }
        // ---------------------------------

        include 'views/room/index.php';
    }

    // Hiển thị Form thêm mới
    public function create() {
        $stmt = $this->room->readRoomTypes();
        $roomTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include 'views/room/create.php';
    }

    // --- SỬA LẠI: Xử lý lưu dữ liệu (CÓ UPLOAD ẢNH) ---
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 1. Lấy dữ liệu text
            $this->room->room_number = $_POST['room_number'];
            $this->room->type_id = $_POST['type_id'];
            $this->room->status = $_POST['status'];

            // 2. Xử lý file ảnh
            $this->room->image = "default.jpg"; // Giá trị mặc định nếu không up ảnh

            // Kiểm tra xem người dùng có chọn file không và không có lỗi
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "assets/uploads/";
                // Đặt tên file = timestamp + tên gốc (để tránh trùng tên)
                $file_name = time() . "_" . basename($_FILES["image"]["name"]); 
                $target_file = $target_dir . $file_name;
                
                // Thực hiện upload file vào thư mục assets/uploads
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $this->room->image = $file_name; // Gán tên file mới vào model
                }
            }

            // 3. Gọi Model để lưu
            if($this->room->create()) {
                header("Location: index.php?page=rooms&message=success");
            } else {
                echo "Lỗi: Không thể tạo phòng.";
            }
        }
    }

    // --- CHỨC NĂNG SỬA ---
    
    // Hiển thị Form Sửa
    public function edit() {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');

        $this->room->room_id = $id;
        $this->room->readOne();

        $stmt = $this->room->readRoomTypes();
        $roomTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include 'views/room/edit.php';
    }

    // --- SỬA LẠI: Xử lý cập nhật (CÓ XỬ LÝ ẢNH CŨ/MỚI) ---
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->room->room_id = $_POST['room_id'];
            $this->room->room_number = $_POST['room_number'];
            $this->room->type_id = $_POST['type_id'];
            $this->room->status = $_POST['status'];

            // 1. Logic xử lý ảnh
            // Mặc định lấy tên ảnh cũ (được gửi từ input hidden 'old_image')
            $old_image = isset($_POST['old_image']) ? $_POST['old_image'] : 'default.jpg';
            $this->room->image = $old_image;

            // 2. Nếu người dùng chọn ảnh MỚI thì upload và ghi đè
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "assets/uploads/";
                $file_name = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $file_name;
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $this->room->image = $file_name; // Cập nhật tên ảnh mới
                }
            }

            // 3. Gọi Model cập nhật
            if($this->room->update()) {
                header("Location: index.php?page=rooms&message=updated");
            } else {
                echo "Lỗi: Không thể cập nhật phòng.";
            }
        }
    }

    // --- CHỨC NĂNG XÓA ---
    public function delete() {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');
        
        $this->room->room_id = $id;
        
        if($this->room->delete()) {
            header("Location: index.php?page=rooms&message=deleted");
        } else {
            echo "Lỗi: Không thể xóa phòng (Có thể phòng đang có đơn đặt).";
        }
    }
}
?>