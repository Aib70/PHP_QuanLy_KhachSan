<?php
// index.php
session_start(); // QUAN TRỌNG: Khởi tạo Session

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

    // 5. QUẢN LÝ PHÒNG (ADMIN ROOMS) - Đã gộp đầy đủ chức năng
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
            case 'edit':   $controller->edit(); break;   // <--- Đã có Sửa
            case 'update': $controller->update(); break; // <--- Đã có Cập nhật
            case 'delete': $controller->delete(); break; // <--- Đã có Xóa
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

    // 9. ADMIN: CẬP NHẬT TRẠNG THÁI ĐƠN
    case 'admin_booking_update':
        include_once 'controllers/BookingController.php';
        $controller = new BookingController();
        $controller->adminUpdateStatus();
        break;

    // Mặc định về Home
    default:
        include_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
}
?>