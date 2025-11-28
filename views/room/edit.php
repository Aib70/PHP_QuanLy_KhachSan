<?php include 'views/layout/header.php'; ?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Cập Nhật Phòng <?php echo $this->room->room_number; ?></h4>
            </div>
            <div class="card-body">
                
                <form action="index.php?page=rooms&action=update" method="POST" enctype="multipart/form-data">
                    
                    <input type="hidden" name="room_id" value="<?php echo $this->room->room_id; ?>">
                    
                    <input type="hidden" name="old_image" value="<?php echo $this->room->image; ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Số phòng</label>
                        <input type="text" name="room_number" class="form-control" 
                               value="<?php echo $this->room->room_number; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Loại phòng</label>
                        <select name="type_id" class="form-select" required>
                            <?php foreach($roomTypes as $type): ?>
                                <option value="<?php echo $type['type_id']; ?>" 
                                    <?php echo ($type['type_id'] == $this->room->type_id) ? 'selected' : ''; ?>>
                                    <?php echo $type['type_name']; ?> - <?php echo number_format($type['price_per_night']); ?> VNĐ
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="Available" <?php echo ($this->room->status == 'Available') ? 'selected' : ''; ?>>Trống (Available)</option>
                            <option value="Cleaning" <?php echo ($this->room->status == 'Cleaning') ? 'selected' : ''; ?>>Đang dọn (Cleaning)</option>
                            <option value="Booked" <?php echo ($this->room->status == 'Booked') ? 'selected' : ''; ?>>Đã đặt (Booked)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Hình ảnh hiện tại</label>
                        <div class="mb-2">
                            <?php if(!empty($this->room->image)): ?>
                                <img src="assets/uploads/<?php echo $this->room->image; ?>" 
                                     class="img-thumbnail" width="200px" alt="Ảnh phòng">
                            <?php else: ?>
                                <span class="text-muted">Chưa có ảnh</span>
                            <?php endif; ?>
                        </div>
                        
                        <label class="form-label fw-bold">Chọn ảnh mới (Nếu muốn thay đổi)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text text-muted">Bỏ qua trường này nếu bạn muốn giữ nguyên ảnh cũ.</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="index.php?page=rooms" class="btn btn-secondary me-md-2">Quay lại</a>
                        <button type="submit" class="btn btn-warning fw-bold">Lưu Thay Đổi</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>