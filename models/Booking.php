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
        // Join với bảng Rooms để lấy số phòng
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
        // Chỉ cho phép hủy nếu đơn đó thuộc về User này VÀ đang ở trạng thái Pending
        $query = "UPDATE " . $this->table . " 
                  SET status = 'Cancelled' 
                  WHERE booking_id = :booking_id 
                  AND user_id = :user_id 
                  AND status = 'Pending'";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':booking_id', $booking_id);
        $stmt->bindParam(':user_id', $user_id);

        if($stmt->execute()) {
            // Kiểm tra xem có dòng nào bị ảnh hưởng không (nếu = 0 nghĩa là sai ID hoặc đơn không phải Pending)
            if($stmt->rowCount() > 0) {
                return true;
            }
        }
        return false;
    }
   
    // 4. ADMIN: Lấy TẤT CẢ đơn đặt phòng (kèm thông tin người dùng)
    public function getAllBookings() {
        $query = "SELECT b.*, r.room_number, u.username, u.full_name
                  FROM " . $this->table . " b
                  LEFT JOIN Rooms r ON b.room_id = r.room_id
                  LEFT JOIN Users u ON b.user_id = u.user_id
                  ORDER BY b.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 5. ADMIN: Cập nhật trạng thái (Duyệt hoặc Hủy bất kỳ đơn nào)
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
}
?>