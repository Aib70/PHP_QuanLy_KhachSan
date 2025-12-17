<?php include 'views/layout/header.php'; ?>

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow">
        <div class="card-header bg-dark text-white text-center">
            <h3>Đăng Nhập Hệ Thống</h3>
        </div>
        <div class="card-body">
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="index.php?page=login" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            <!--Tạo Cookies -->
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
            </form>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>