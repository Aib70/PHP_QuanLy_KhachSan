<?php
// index.php
session_start(); // QUAN TRỌNG: Khởi tạo Session

// Include các file cần thiết để kiểm tra Cookie
include_once 'config/db.php';
include_once 'models/User.php';

// --- LOGIC TỰ ĐỘNG ĐĂNG NHẬP BẰNG COOKIE ---
// Nếu chưa có Session (chưa đăng nhập) NHƯNG trình duyệt có Cookie 'user_login'
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_login'])) {
    $user_id = $_COOKIE['user_login'];

    // Kết nối DB để lấy thông tin user này
    $database = new Database();
    $db = $database->getConnection();
    $userModel = new User($db);
    
    // Gán ID vào model để tìm
    $userModel->user_id = $user_id;
    
    // Gọi hàm readOne để lấy thông tin user (username, role...)
    if($userModel->readOne()) {
        // Tái tạo lại Session => Coi như đã đăng nhập thành công
        $_SESSION['user_id'] = $userModel->user_id;
        $_SESSION['username'] = $userModel->username;
        $_SESSION['role'] = $userModel->role;
    }
}
// ---------------------------------------------

// Lấy tham số 'page' từ URL, nếu không có thì mặc định là 'home'
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($page) {
    // 1. TRANG CHỦ
    case 'home':
        include_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

    // 2. AUTH: ĐĂNG NHẬP
    case 'login':
        include_once 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->login();
        break;
        
    // 3. AUTH: ĐĂNG KÝ
    case 'register':
        include_once 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->register();
        break;

    // 4. AUTH: ĐĂNG XUẤT
    case 'logout':
        include_once 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->logout();
        break;

    // 5. QUẢN LÝ PHÒNG (ADMIN ROOMS)
    case 'rooms':
        // Kiểm tra quyền Admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
             header("Location: index.php?page=login");
             exit;
        }

        include_once 'controllers/RoomController.php';
        $controller = new RoomController();
        
        switch ($action) {
            case 'create': $controller->create(); break;
            case 'store':  $controller->store(); break;
            case 'edit':   $controller->edit(); break;
            case 'update': $controller->update(); break;
            case 'delete': $controller->delete(); break;
            default:       $controller->index(); break;
        }
        break;

    // 6. KHÁCH HÀNG: ĐẶT PHÒNG
    case 'booking':
        include_once 'controllers/BookingController.php';
        $controller = new BookingController();
        switch ($action) {
            case 'create': $controller->create(); break;
            case 'store':  $controller->store(); break;
            case 'cancel': $controller->cancel(); break;
            default:       $controller->create(); break;
        }
        break;

    // 7. KHÁCH HÀNG: LỊCH SỬ
    case 'booking_history':
        include_once 'controllers/BookingController.php';
        $controller = new BookingController();
        $controller->history();
        break;

    // 8. ADMIN: QUẢN LÝ ĐƠN HÀNG
    case 'admin_bookings':
        include_once 'controllers/BookingController.php';
        $controller = new BookingController();
        $controller->adminIndex();
        break;
        //Xem đơn đã xong/hủy
    case 'admin_history':
        include_once 'controllers/BookingController.php';
        $controller = new BookingController();
        $controller->adminHistory(); // Chúng ta sẽ tạo hàm này ngay dưới
        break;

    // 9. ADMIN: CẬP NHẬT TRẠNG THÁI ĐƠN
    case 'admin_booking_update':
        include_once 'controllers/BookingController.php';
        $controller = new BookingController();
        $controller->adminUpdateStatus();
        break;
   
    // 10. QUẢN LÝ NHÂN VIÊN (ADMIN STAFF)
    case 'staff':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
             header("Location: index.php?page=login"); exit;
        }
        include_once 'controllers/StaffController.php';
        $controller = new StaffController();
        
        switch ($action) {
            case 'create': $controller->create(); break;
            case 'store':  $controller->store(); break;
            case 'edit':   $controller->edit(); break;
            case 'update': $controller->update(); break;
            case 'delete': $controller->delete(); break;
            case 'show':   $controller->show(); break;
            default:       $controller->index(); break;
        }
        break;

    // Mặc định về Home
    default:
        include_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
}
?>