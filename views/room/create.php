<?php include 'views/layout/header.php'; ?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Thêm Phòng Mới</h4>
            </div>
            <div class="card-body">
                <form action="index.php?page=rooms&action=store" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Số phòng</label>
                        <input type="text" name="room_number" class="form-control" placeholder="Ví dụ: 101, 205..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Loại phòng</label>
                        <select name="type_id" class="form-select" required>
                            <option value="">-- Chọn loại phòng --</option>
                            <?php foreach($roomTypes as $type): ?>
                                <option value="<?php echo $type['type_id']; ?>">
                                    <?php echo $type['type_name']; ?> - <?php echo number_format($type['price_per_night']); ?> VNĐ
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Trạng thái ban đầu</label>
                        <select name="status" class="form-select">
                            <option value="Available">Trống (Available)</option>
                            <option value="Cleaning">Đang dọn (Cleaning)</option>
                            <option value="Booked">Đã đặt (Booked)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Hình ảnh phòng</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text">Nên chọn ảnh kích thước chuẩn (VD: JPG, PNG).</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="index.php?page=rooms" class="btn btn-secondary me-md-2">Quay lại</a>
                        <button type="submit" class="btn btn-success fw-bold">Lưu Phòng</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>