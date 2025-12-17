<?php
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../models/User.php';

class AuthController {
    
    // Chức năng Đăng nhập
    public function login() {
        // Nếu đã đăng nhập thì đá về trang chủ
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
                // 1. Lưu Session (Bắt buộc)
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; 

                // 2. XỬ LÝ COOKIE (Ghi nhớ đăng nhập) - MỚI THÊM
                if (isset($_POST['remember'])) {
                    // Tạo cookie lưu User ID, tồn tại trong 30 ngày (86400 giây * 30)
                    // Dấu "/" có nghĩa là cookie có hiệu lực trên toàn bộ website
                    setcookie('user_login', $user['user_id'], time() + (86400 * 30), "/");
                }

                // Điều hướng: Admin thì vào quản trị, Khách thì ra trang chủ
                if($user['role'] == 'admin') {
                    header("Location: index.php?page=rooms"); 
                } else {
                    header("Location: index.php?page=home");
                }
                
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
        // 1. Xóa Session
        session_destroy();
        
        // 2. Xóa Cookie (MỚI THÊM)
        // Đặt thời gian về quá khứ để trình duyệt tự xóa
        if (isset($_COOKIE['user_login'])) {
            setcookie('user_login', '', time() - 3600, "/");
        }

        header("Location: index.php?page=home");
        exit;
    }

    // Chức năng Đăng ký (Giữ nguyên)
    public function register() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?page=home");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $database = new Database();
            $db = $database->getConnection();
            $userModel = new User($db); 

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

            // 3. Tiến hành đăng ký (Thêm các trường email, phone, position rỗng nếu chưa nhập ở form đăng ký đơn giản)
            // Lưu ý: Nếu Model User của bạn hàm register chỉ nhận 3 tham số thì giữ nguyên
            // Nếu bạn đã cập nhật Model User nhận nhiều tham số hơn (như bước Staff) thì cần cập nhật dòng này.
            // Ở đây tôi giả định dùng hàm register cơ bản cho khách hàng:
            if ($userModel->register($username, $password, $full_name)) {
                header("Location: index.php?page=login&message=registered");
            } else {
                $error = "Có lỗi xảy ra, vui lòng thử lại!";
                include 'views/auth/register.php';
            }

        } else {
            include 'views/auth/register.php';
        }
    }
}
?>