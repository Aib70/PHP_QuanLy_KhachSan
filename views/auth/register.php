<?php include 'views/layout/header.php'; ?>

<div class="container mt-5 mb-5" style="max-width: 600px;">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-dark text-white text-center py-3 rounded-top-4">
            <h3 class="mb-0 fw-bold">Đăng Ký Tài Khoản</h3>
            <p class="small mb-0 opacity-75">Trở thành thành viên của MR.travel</p>
        </div>
        <div class="card-body p-4">
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="index.php?page=register" method="POST">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Họ và Tên</label>
                    <input type="text" name="full_name" class="form-control" placeholder="Nhập họ tên đầy đủ" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control" placeholder="Viết liền không dấu" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nhập lại mật khẩu</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold">Đăng Ký Ngay</button>
                </div>

                <div class="text-center mt-3">
                    <span class="text-muted">Bạn đã có tài khoản?</span> 
                    <a href="index.php?page=login" class="text-decoration-none fw-bold">Đăng nhập tại đây</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>