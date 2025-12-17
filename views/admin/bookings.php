<?php include 'views/layout/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary"><i class="fas fa-tasks me-2"></i>Quản Lý Đặt Phòng Hiện Tại</h2>
        
        <div>
            <a href="index.php?page=admin_history" class="btn btn-secondary me-2">
                <i class="fas fa-history me-1"></i> Lịch sử & Doanh thu
            </a>
            
            <a href="index.php?page=rooms" class="btn btn-outline-primary">
                <i class="fas fa-door-open me-1"></i> Quản lý Phòng
            </a>
        </div>
    </div>

    <?php if(isset($_GET['message']) && $_GET['message'] == 'updated'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Cập nhật trạng thái thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Phòng</th>
                        <th>Thời gian</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th width="180px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($bookings) && count($bookings) > 0): ?>
                        <?php foreach($bookings as $row): ?>
                            <tr>
                                <td class="text-center align-middle">#<?php echo $row['booking_id']; ?></td>
                                
                                <td class="align-middle">
                                    <div class="fw-bold text-primary"><?php echo $row['full_name']; ?></div>
                                    <div class="small text-muted"><i class="fas fa-user-circle"></i> <?php echo $row['username']; ?></div>
                                </td>
                                
                                <td class="text-center align-middle">
                                    <span class="badge bg-info text-dark fs-6">Phòng <?php echo $row['room_number']; ?></span>
                                </td>
                                
                                <td class="align-middle small">
                                    <div><i class="fas fa-calendar-check text-success"></i> In: <b><?php echo date('d/m/Y', strtotime($row['check_in_date'])); ?></b></div>
                                    <div><i class="fas fa-calendar-times text-danger"></i> Out: <b><?php echo date('d/m/Y', strtotime($row['check_out_date'])); ?></b></div>
                                </td>
                                
                                <td class="text-center align-middle fw-bold text-success">
                                    <?php echo number_format($row['total_price']); ?> đ
                                </td>
                                
                                <td class="text-center align-middle">
                                    <?php 
                                        if($row['status'] == 'Pending') 
                                            echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                        elseif($row['status'] == 'Confirmed') 
                                            echo '<span class="badge bg-success">Đang ở</span>';
                                        else 
                                            echo '<span class="badge bg-secondary">Khác</span>';
                                    ?>
                                </td>
                                
                                <td class="text-center align-middle">
                                    
                                    <?php if($row['status'] == 'Pending'): ?>
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="index.php?page=admin_booking_update&id=<?php echo $row['booking_id']; ?>&status=Confirmed" 
                                               class="btn btn-sm btn-success" title="Duyệt đơn">
                                               <i class="fas fa-check"></i>
                                            </a>
                                            
                                            <a href="index.php?page=admin_booking_update&id=<?php echo $row['booking_id']; ?>&status=Cancelled" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Bạn có chắc chắn muốn HỦY đơn này không?');" title="Hủy đơn">
                                               <i class="fas fa-times"></i>
                                            </a>
                                        </div>

                                    <?php elseif($row['status'] == 'Confirmed'): ?>
                                        <a href="index.php?page=admin_booking_update&id=<?php echo $row['booking_id']; ?>&status=Completed" 
                                           class="btn btn-sm btn-primary w-100"
                                           onclick="return confirm('Xác nhận khách đã thanh toán và trả phòng? Đơn hàng sẽ chuyển vào Lịch sử.');">
                                           <i class="fas fa-check-double"></i> Trả phòng
                                        </a>

                                    <?php else: ?>
                                        <span class="text-muted small"><i class="fas fa-lock"></i> Đã đóng</span>
                                    <?php endif; ?>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-clipboard-check fa-3x mb-3"></i><br>
                                Hiện tại không có đơn đặt phòng nào đang chờ hoặc đang ở.<br>
                                <small>Kiểm tra mục <b>Lịch sử</b> để xem các đơn đã hoàn tất.</small>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>