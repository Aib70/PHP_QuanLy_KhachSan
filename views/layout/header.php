<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MR.travel - Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="index.php">MR.travel</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto"> 
                <li class="nav-item"><a class="nav-link active" href="index.php?page=home">Tìm hiểu</a></li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                       <a class="nav-link fw-bold" href="index.php?page=booking_history">Lịch sử đạt</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item"><a class="nav-link" href="#">Giá ưu đãi</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Giớ Thiệu</a></li>
                
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    
                    <li class="nav-item">
                        <a class="nav-link text-danger fw-bold" href="index.php?page=rooms">Admin Room</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link text-primary fw-bold" href="index.php?page=admin_bookings">Admin Bookings</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-success fw-bold" href="index.php?page=staff">Admin Staff</a>
                    </li>

                <?php endif; ?>
            </ul>
            
            <div class="d-flex gap-2 align-items-center">
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    
                    <span class="navbar-text me-2">
                        Hi, <b><?php echo $_SESSION['username']; ?></b>
                    </span>
                    <a href="index.php?page=logout" class="btn btn-outline-danger rounded-pill px-4">Logout</a>

                <?php else: ?>
                    
                    <a href="index.php?page=register" class="btn btn-outline-dark rounded-pill px-4">Register</a>
                    <a href="index.php?page=login" class="btn btn-dark rounded-pill px-4">Login</a>
                
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>