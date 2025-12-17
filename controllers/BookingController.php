<?php
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../models/Booking.php';
include_once __DIR__ . '/../models/Room.php'; // Cần cái này để lấy giá phòng

class BookingController {
    
    // Hiển thị form đặt phòng
    public function create() {
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login&message=Please login to book");
            exit;
        }

        // 2. Lấy thông tin phòng đang chọn để hiện giá
        $room_id = isset($_GET['room_id']) ? $_GET['room_id'] : die('ERROR: Missing Room ID.');
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Đoạn này lấy thông tin phòng (bạn cần thêm hàm getById vào Model Room nếu chưa có, 
        // nhưng để đơn giản ta tạm truyền giá qua URL hoặc query nhanh tại đây)
        // Ở đây mình giả định giá phòng, thực tế bạn nên query từ DB
        $price_per_night = isset($_GET['price']) ? $_GET['price'] : 0;

        include 'views/booking/create.php';
    }

    // Xử lý lưu đơn đặt phòng
    public function store() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $database = new Database();
            $db = $database->getConnection();
            $bookingModel = new Booking($db);

            $user_id = $_SESSION['user_id'];
            $room_id = $_POST['room_id'];
            $check_in = $_POST['check_in'];
            $check_out = $_POST['check_out'];
            $price_per_night = $_POST['price_per_night'];

            // TÍNH TOÁN TỔNG TIỀN
            $date1 = new DateTime($check_in);
            $date2 = new DateTime($check_out);
            $interval = $date1->diff($date2);
            $days = $interval->days; // Số ngày ở
            
            if ($days <= 0) $days = 1; // Ít nhất tính 1 ngày

            $total_price = $days * $price_per_night;

            if ($bookingModel->create($user_id, $room_id, $check_in, $check_out, $total_price)) {
                header("Location: index.php?page=booking_history");
            } else {
                echo "Lỗi đặt phòng!";
            }
        }
    }

    // Xem lịch sử
    public function history() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        $bookingModel = new Booking($db);

        $stmt = $bookingModel->getHistory($_SESSION['user_id']);
        $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include 'views/booking/history.php';
    }
   
    // Xử lý Hủy phòng
    public function cancel() {
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        // 2. Lấy ID đơn hàng
        $booking_id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');

        $database = new Database();
        $db = $database->getConnection();
        $bookingModel = new Booking($db);

        // 3. Gọi Model để hủy (Truyền ID đơn và ID người dùng hiện tại)
        if ($bookingModel->cancel($booking_id, $_SESSION['user_id'])) {
            // Hủy thành công -> Quay lại trang lịch sử
            header("Location: index.php?page=booking_history&message=cancelled");
        } else {
            // Hủy thất bại (do không phải chính chủ hoặc đơn đã duyệt rồi)
            echo "<script>alert('Không thể hủy đơn này! Có thể đơn đã được duyệt hoặc không tồn tại.'); window.location.href='index.php?page=booking_history';</script>";
        }
    }
    

    // --- KHU VỰC ADMIN ---

    // Hiển thị danh sách tất cả đơn hàng
   public function adminIndex() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=login");
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        $bookingModel = new Booking($db);

        // SỬA DÒNG NÀY: Gọi hàm getActiveBookings
        $stmt = $bookingModel->getActiveBookings(); 
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include 'views/admin/bookings.php';
    }

    // Xử lý Duyệt/Hủy đơn
    public function adminUpdateStatus() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            die('Access Denied');
        }

        $booking_id = $_GET['id'];
        $status = $_GET['status']; // Confirmed, Cancelled, Completed

        $database = new Database();
        $db = $database->getConnection();
        $bookingModel = new Booking($db);
        $roomModel = new Room($db);

        // 1. Cập nhật trạng thái đơn hàng
        if ($bookingModel->updateStatus($booking_id, $status)) {
            
            // 2. Lấy ID phòng của đơn hàng này
            $room_id = $bookingModel->getRoomIdByBooking($booking_id);

            // 3. LOGIC TỰ ĐỘNG CẬP NHẬT TRẠNG THÁI PHÒNG
            if($room_id) {
                if ($status == 'Confirmed') {
                    // Nếu Duyệt đơn -> Phòng thành 'Booked' (Để ẩn khỏi Home)
                    $roomModel->updateStatusOnly($room_id, 'Booked');
                } 
                elseif ($status == 'Completed') {
                    // Nếu Trả phòng (Check-out) -> Phòng thành 'Available' (Hiện lại Home)
                    $roomModel->updateStatusOnly($room_id, 'Available');
                }
                elseif ($status == 'Cancelled') {
                    // Nếu Hủy đơn -> Phòng thành 'Available'
                    $roomModel->updateStatusOnly($room_id, 'Available');
                }
            }

            header("Location: index.php?page=admin_bookings&message=updated");
        } else {
            echo "Lỗi cập nhật!";
        }
    }
    
    public function adminHistory() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') exit;

        $database = new Database();
        $db = $database->getConnection();
        $bookingModel = new Booking($db);

        // Lấy danh sách đơn đã xong/hủy
        $stmt = $bookingModel->getAllHistory();
        $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include 'views/admin/history.php'; // Tạo file view này ở bước sau
    }
}
?>