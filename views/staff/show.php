<?php include 'views/layout/header.php'; ?>
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="100" class="mb-3 rounded-circle border p-2">
                    <h3 class="card-title fw-bold"><?php echo $this->user->full_name; ?></h3>
                    <span class="badge bg-primary fs-6"><?php echo $this->user->position; ?></span>
                </div>
                
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong><i class="fas fa-id-card me-2 text-muted"></i>ID Nhân viên:</strong> 
                        <span>#<?php echo $this->user->user_id; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong><i class="fas fa-user me-2 text-muted"></i>Tài khoản:</strong> 
                        <span><?php echo $this->user->username; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong><i class="fas fa-phone me-2 text-muted"></i>Điện thoại:</strong> 
                        <span><?php echo $this->user->phone ? $this->user->phone : 'Chưa cập nhật'; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong><i class="fas fa-envelope me-2 text-muted"></i>Email:</strong> 
                        <span><?php echo $this->user->email ? $this->user->email : 'Chưa cập nhật'; ?></span>
                    </li>
                </ul>
                
                <div class="d-grid gap-2 mt-4">
                    <a href="index.php?page=staff&action=edit&id=<?php echo $this->user->user_id; ?>" class="btn btn-warning fw-bold"><i class="fas fa-edit"></i> Chỉnh sửa hồ sơ</a>
                    <a href="index.php?page=staff" class="btn btn-light"><i class="fas fa-arrow-left"></i> Quay lại danh sách</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>