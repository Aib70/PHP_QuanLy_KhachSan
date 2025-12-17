<?php
class Booking {
    private $conn;
    private $table = "Bookings";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Tạo đơn đặt phòng mới
    public function create($user_id, $room_id, $check_in, $check_out, $total_price) {
        $query = "INSERT INTO " . $this->table . " 
                  SET user_id=:user_id, room_id=:room_id, 
                      check_in_date=:check_in, check_out_date=:check_out, 
                      total_price=:total_price, status='Pending'";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":room_id", $room_id);
        $stmt->bindParam(":check_in", $check_in);
        $stmt->bindParam(":check_out", $check_out);
        $stmt->bindParam(":total_price", $total_price);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // 2. Lấy lịch sử đặt phòng của 1 user
    public function getHistory($user_id) {
        $query = "SELECT b.*, r.room_number 
                  FROM " . $this->table . " b
                  LEFT JOIN Rooms r ON b.room_id = r.room_id
                  WHERE b.user_id = :user_id
                  ORDER BY b.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt;
    }

    // 3. Hủy đơn đặt phòng (Chuyển trạng thái sang Cancelled)
    public function cancel($booking_id, $user_id) {
        $query = "UPDATE " . $this->table . " 
                  SET status = 'Cancelled' 
                  WHERE booking_id = :booking_id 
                  AND user_id = :user_id 
                  AND status = 'Pending'";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':booking_id', $booking_id);
        $stmt->bindParam(':user_id', $user_id);

        if($stmt->execute()) {
            if($stmt->rowCount() > 0) {
                return true;
            }
        }
        return false;
    }
   
    // 4. ADMIN: Chỉ lấy các đơn ĐANG HOẠT ĐỘNG (Pending, Confirmed)
    // Để bảng quản lý không bị rác bởi các đơn đã xong
    public function getActiveBookings() {
        $query = "SELECT b.*, r.room_number, u.username, u.full_name
                  FROM " . $this->table . " b
                  LEFT JOIN Rooms r ON b.room_id = r.room_id
                  LEFT JOIN Users u ON b.user_id = u.user_id
                  WHERE b.status IN ('Pending', 'Confirmed')
                  ORDER BY b.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 5. ADMIN: Lấy lịch sử tất cả (Dùng cho trang Báo cáo hoặc Lịch sử riêng nếu cần)
    public function getAllHistory() {
        $query = "SELECT b.*, r.room_number, u.username, u.full_name
                  FROM " . $this->table . " b
                  LEFT JOIN Rooms r ON b.room_id = r.room_id
                  LEFT JOIN Users u ON b.user_id = u.user_id
                  WHERE b.status IN ('Completed', 'Cancelled')
                  ORDER BY b.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 6. ADMIN: Cập nhật trạng thái
    public function updateStatus($booking_id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE booking_id = :booking_id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':booking_id', $booking_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // 7. Lấy ID phòng từ ID đơn hàng
    public function getRoomIdByBooking($booking_id) {
        $query = "SELECT room_id FROM " . $this->table . " WHERE booking_id = :booking_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':booking_id', $booking_id);
        $stmt->execute();
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            return $row['room_id'];
        }
        return false;
    }
}
?>