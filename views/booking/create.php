<?php include 'views/layout/header.php'; ?>

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Xác nhận đặt phòng</h4>
        </div>
        <div class="card-body">
            <form action="index.php?page=booking&action=store" method="POST">
                
                <input type="hidden" name="room_id" value="<?php echo $_GET['room_id']; ?>">
                <input type="hidden" name="price_per_night" value="<?php echo $_GET['price']; ?>">

                <div class="alert alert-info">
                    Bạn đang đặt phòng ID: <strong><?php echo $_GET['room_id']; ?></strong><br>
                    Giá: <strong><?php echo number_format($_GET['price']); ?> VNĐ/đêm</strong>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày nhận phòng (Check-in)</label>
                        <input type="date" name="check_in" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày trả phòng (Check-out)</label>
                        <input type="date" name="check_out" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>

                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-success btn-lg">Xác nhận Đặt & Thanh toán sau</button>
                    <a href="index.php?page=home" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>