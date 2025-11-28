<?php
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../models/Room.php';

class HomeController {
    public function index() {
        $database = new Database();
        $db = $database->getConnection();
        $room = new Room($db);
        
        // KIỂM TRA TÌM KIẾM
        // Nếu trên URL có biến 'keyword' (VD: ?page=home&keyword=VIP)
        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $stmt = $room->search($keyword); // Gọi hàm tìm kiếm
        } else {
            // Nếu không tìm gì thì hiện tất cả
            $stmt = $room->readAll();
        }

        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include 'views/home/index.php';
    }
}
?>