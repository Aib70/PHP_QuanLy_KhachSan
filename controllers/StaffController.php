<?php
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../models/User.php';

class StaffController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function index() {
        $stmt = $this->user->readAllStaff();
        $staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include 'views/staff/index.php';
    }

    public function create() {
        include 'views/staff/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->user->checkUsernameExists($_POST['username'])) {
                $error = "Tên đăng nhập đã tồn tại!";
                include 'views/staff/create.php';
                return;
            }

            $this->user->username = $_POST['username'];
            $this->user->password = $_POST['password'];
            $this->user->full_name = $_POST['full_name'];
            // Lấy dữ liệu mới
            $this->user->email = $_POST['email'];
            $this->user->phone = $_POST['phone'];
            $this->user->position = $_POST['position'];

            if ($this->user->create()) {
                header("Location: index.php?page=staff&message=created");
            } else {
                $error = "Lỗi khi thêm nhân viên.";
                include 'views/staff/create.php';
            }
        }
    }

    public function edit() {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');
        $this->user->user_id = $id;
        $this->user->readOne();
        include 'views/staff/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->user_id = $_POST['user_id'];
            $this->user->full_name = $_POST['full_name'];
            $this->user->email = $_POST['email'];
            $this->user->phone = $_POST['phone'];
            $this->user->position = $_POST['position'];
            
            if (!empty($_POST['password'])) {
                $this->user->password = $_POST['password'];
            } else {
                $this->user->password = $_POST['old_password'];
            }

            if ($this->user->update()) {
                header("Location: index.php?page=staff&message=updated");
            } else {
                echo "Lỗi cập nhật.";
            }
        }
    }

    public function show() {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');
        $this->user->user_id = $id;
        $this->user->readOne();
        include 'views/staff/show.php';
    }

    public function delete() {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');
        $this->user->user_id = $id;
        if ($this->user->delete()) {
            header("Location: index.php?page=staff&message=deleted");
        } else {
            echo "Lỗi xóa nhân viên.";
        }
    }
}
?>