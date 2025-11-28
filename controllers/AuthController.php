<?php
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../models/User.php';

class AuthController {
    
    // Chức năng Đăng nhập
    public function login() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?page=home");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $database = new Database();
            $db = $database->getConnection();
            $userModel = new User($db);

            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $userModel->login($username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; 
                header("Location: index.php?page=rooms"); 
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
                include 'views/auth/login.php';
            }
        } else {
            include 'views/auth/login.php';
        }
    }

    // Chức năng Đăng xuất
    public function logout() {
        session_destroy();
        header("Location: index.php?page=home");
        exit;
    }

    // Chức năng Đăng ký (Code bạn đang bị lỗi nằm ở đây)
    public function register() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?page=home");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $database = new Database();
            $db = $database->getConnection();
            $userModel = new User($db); // Khởi tạo Model ở đây mới đúng

            // Lấy dữ liệu từ form
            $full_name = $_POST['full_name'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // 1. Kiểm tra mật khẩu nhập lại
            if ($password !== $confirm_password) {
                $error = "Mật khẩu xác nhận không khớp!";
                include 'views/auth/register.php';
                return;
            }

            // 2. Kiểm tra tên đăng nhập đã tồn tại chưa
            if ($userModel->checkUsernameExists($username)) {
                $error = "Tên đăng nhập này đã có người sử dụng!";
                include 'views/auth/register.php';
                return;
            }

            // 3. Tiến hành đăng ký
            if ($userModel->register($username, $password, $full_name)) {
                // Đăng ký thành công -> Chuyển hướng về trang Login
                header("Location: index.php?page=login&message=registered");
            } else {
                $error = "Có lỗi xảy ra, vui lòng thử lại!";
                include 'views/auth/register.php';
            }

        } else {
            // Hiển thị form đăng ký
            include 'views/auth/register.php';
        }
    }
}
?>