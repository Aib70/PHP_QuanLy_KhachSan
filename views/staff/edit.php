<?php include 'views/layout/header.php'; ?>
<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-warning"><h4><i class="fas fa-user-edit"></i> Cập Nhật Nhân Viên</h4></div>
            <div class="card-body">
                <form action="index.php?page=staff&action=update" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $this->user->user_id; ?>">
                    <input type="hidden" name="old_password" value="<?php echo $this->user->password; ?>">
                    
                    <div class="mb-3">
                        <label class="fw-bold">Tên đăng nhập (Không thể sửa)</label>
                        <input type="text" value="<?php echo $this->user->username; ?>" class="form-control" disabled>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Họ và Tên</label>
                            <input type="text" name="full_name" value="<?php echo $this->user->full_name; ?>" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Chức vụ</label>
                            <select name="position" class="form-select">
                                <option value="Lễ tân" <?php echo ($this->user->position == 'Lễ tân') ? 'selected' : ''; ?>>Lễ tân</option>
                                <option value="Kế toán" <?php echo ($this->user->position == 'Kế toán') ? 'selected' : ''; ?>>Kế toán</option>
                                <option value="CSKH" <?php echo ($this->user->position == 'CSKH') ? 'selected' : ''; ?>>Chăm sóc khách hàng</option>
                                <option value="Bảo vệ" <?php echo ($this->user->position == 'Bảo vệ') ? 'selected' : ''; ?>>Bảo vệ</option>
                                <option value="Buồng phòng" <?php echo ($this->user->position == 'Buồng phòng') ? 'selected' : ''; ?>>Buồng phòng</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Email</label>
                            <input type="email" name="email" value="<?php echo $this->user->email; ?>" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Số điện thoại</label>
                            <input type="text" name="phone" value="<?php echo $this->user->phone; ?>" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Mật khẩu mới (Để trống nếu không đổi)</label>
                        <input type="password" name="password" class="form-control" placeholder="******">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php?page=staff" class="btn btn-secondary me-2">Quay lại</a>
                        <button type="submit" class="btn btn-warning">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>