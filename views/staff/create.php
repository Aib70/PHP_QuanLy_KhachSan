<?php include 'views/layout/header.php'; ?>
<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white"><h4><i class="fas fa-user-plus"></i> Thêm Nhân Viên Mới</h4></div>
            <div class="card-body">
                <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <form action="index.php?page=staff&action=store" method="POST">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Họ và Tên</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Chức vụ</label>
                            <select name="position" class="form-select">
                                <option value="Lễ tân">Lễ tân</option>
                                <option value="Kế toán">Kế toán</option>
                                <option value="CSKH">Chăm sóc khách hàng</option>
                                <option value="Bảo vệ">Bảo vệ</option>
                                <option value="Buồng phòng">Buồng phòng</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tên đăng nhập</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php?page=staff" class="btn btn-secondary me-2">Quay lại</a>
                        <button type="submit" class="btn btn-success">Lưu Nhân Viên</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>