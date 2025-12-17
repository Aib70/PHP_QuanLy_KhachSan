<?php include 'views/layout/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-secondary"><i class="fas fa-history me-2"></i>Lịch sử Giao Dịch</h2>
        
        <a href="index.php?page=admin_bookings" class="btn btn-primary">
            <i class="fas fa-arrow-left me-1"></i> Quay lại Đơn hiện tại
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped table-hover mb-0">
                <thead class="table-secondary text-center">
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Phòng</th>
                        <th>Thời gian lưu trú</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo đơn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($history) && count($history) > 0): ?>
                        <?php foreach($history as $row): ?>
                            <tr>
                                <td class="text-center align-middle text-muted">#<?php echo $row['booking_id']; ?></td>
                                
                                <td class="align-middle">
                                    <div class="fw-bold"><?php echo $row['full_name']; ?></div>
                                    <div class="small text-muted"><i class="fas fa-user-circle"></i> <?php echo $row['username']; ?></div>
                                </td>
                                
                                <td class="text-center align-middle">
                                    <span class="badge bg-light text-dark border fs-6">Phòng <?php echo $row['room_number']; ?></span>
                                </td>
                                
                                <td class="align-middle small text-muted">
                                    <div>In: <?php echo date('d/m/Y', strtotime($row['check_in_date'])); ?></div>
                                    <div>Out: <?php echo date('d/m/Y', strtotime($row['check_out_date'])); ?></div>
                                </td>
                                
                                <td class="text-center align-middle fw-bold text-success">
                                    <?php echo number_format($row['total_price']); ?> đ
                                </td>
                                
                                <td class="text-center align-middle">
                                    <?php 
                                        if($row['status'] == 'Completed') 
                                            echo '<span class="badge bg-primary">Hoàn tất</span>';
                                        else 
                                            echo '<span class="badge bg-secondary">Đã hủy</span>';
                                    ?>
                                </td>

                                <td class="text-center align-middle small text-muted">
                                    <?php echo date('H:i d/m/Y', strtotime($row['created_at'])); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-history fa-3x mb-3"></i><br>
                                Chưa có dữ liệu lịch sử nào.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>