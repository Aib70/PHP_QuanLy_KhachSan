<?php include 'views/layout/header.php'; ?>

<div class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="row">
            <div class="col-md-8">
                <h1 class="display-3 fw-bold">The right destination for you and your family</h1>
                <p class="fs-5 mt-3 opacity-75">Trải nghiệm kỳ nghỉ tuyệt vời với hệ thống phòng sang trọng và tiện nghi bậc nhất.</p>
                <a href="#room-list" class="btn btn-dark rounded-pill px-5 py-3 mt-3 fw-bold">Xem Phòng Ngay</a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="search-container">
        <form action="index.php" method="GET">
            
            <input type="hidden" name="page" value="home">

            <div class="row align-items-center">
                <div class="col-md-3">
                    <div class="search-group">
                        <label><i class="fas fa-search me-2"></i>Tìm kiếm</label>
                        <input type="text" name="keyword" 
                               value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>" 
                               placeholder="Nhập loại phòng (VIP, Đơn...)">
                    </div>
                </div>
                
                <div class="col-md-1 d-none d-md-block"><div class="divider"></div></div>

                <div class="col-md-2">
                    <div class="search-group">
                        <label><i class="far fa-calendar-alt me-2"></i>Check-In</label>
                        <input type="text" placeholder="dd - mm - yyyy" onfocus="(this.type='date')">
                    </div>
                </div>

                <div class="col-md-1 d-none d-md-block"><div class="divider"></div></div>

                <div class="col-md-2">
                    <div class="search-group">
                        <label><i class="far fa-calendar-check me-2"></i>Check-Out</label>
                        <input type="text" placeholder="dd - mm - yyyy" onfocus="(this.type='date')">
                    </div>
                </div>

                <div class="col-md-1 d-none d-md-block"><div class="divider"></div></div>
                
                <div class="col-md-2">
                    <div class="search-group">
                        <label><i class="fas fa-user-friends me-2"></i>People</label>
                        <select class="form-select border-0 p-0">
                            <option>1 Person</option>
                            <option>2 People</option>
                            <option>Family</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12 mt-3 mt-md-0 text-end col-lg-auto ms-auto">
                    <button type="submit" class="btn-explore">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="container my-5 pt-5" id="room-list">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h5 class="text-muted text-uppercase mb-1">Our Best Rooms</h5>
            <h2 class="fw-bold">Khám phá các phòng nghỉ</h2>
        </div>
        <?php if(isset($_GET['keyword'])): ?>
            <a href="index.php?page=home" class="text-decoration-none text-danger fw-bold">Xóa tìm kiếm <i class="fas fa-times"></i></a>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        
        <?php if(isset($rooms) && count($rooms) > 0): ?>
            
            <?php foreach($rooms as $row): ?>
                
                <?php if($row['status'] == 'Available'): ?>
                    
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden destination-card">
                            
                            <?php 
                                $img_src = !empty($row['image']) ? "assets/uploads/" . $row['image'] : "https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=500";
                            ?>
                            <div style="height: 220px; overflow: hidden;">
                                <img src="<?php echo $img_src; ?>" class="card-img-top w-100 h-100" style="object-fit: cover;" alt="Room Image">
                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="fw-bold mb-0">Phòng <?php echo $row['room_number']; ?></h5>
                                    <span class="badge bg-light text-dark border"><?php echo $row['type_name']; ?></span>
                                </div>

                                <p class="text-muted small">
                                    <i class="fas fa-check-circle text-success me-1"></i> Wifi miễn phí<br>
                                    <i class="fas fa-check-circle text-success me-1"></i> Dọn phòng hàng ngày
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                    <div>
                                        <span class="fw-bold fs-5 text-primary"><?php echo number_format($row['price_per_night']); ?></span>
                                        <small class="text-muted">/đêm</small>
                                    </div>
                                    
                                    <a href="index.php?page=booking&action=create&room_id=<?php echo $row['room_id']; ?>&price=<?php echo $row['price_per_night']; ?>" 
                                       class="btn btn-dark btn-sm rounded-pill px-4">
                                       Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endif; ?> 
            <?php endforeach; ?>
            
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Không tìm thấy phòng nào phù hợp!</h4>
                <a href="index.php?page=home" class="btn btn-outline-dark mt-2">Xem tất cả phòng</a>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include 'views/layout/footer.php'; ?>