<?php include 'views/layout/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Lịch sử đặt phòng của bạn</h2>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Mã đơn</th>
                    <th>Phòng số</th>
                    <th>Ngày đến</th>
                    <th>Ngày đi</th>
                    <th>Tổng tiền</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
           <tbody>
                <?php if(count($history) > 0): ?>
                    <?php foreach($history as $row): ?>
                        <tr>
                            <td>#<?php echo $row['booking_id']; ?></td>
                            <td><?php echo $row['room_number']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['check_in_date'])); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['check_out_date'])); ?></td>
                            <td class="fw-bold text-success"><?php echo number_format($row['total_price']); ?> VNĐ</td>
                            <td><?php echo $row['created_at']; ?></td>
                            
                            <td>
                                <?php 
                                    if($row['status'] == 'Pending') 
                                        echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                    else if($row['status'] == 'Confirmed') 
                                        echo '<span class="badge bg-success">Đã duyệt</span>';
                                    else if($row['status'] == 'Cancelled') 
                                        echo '<span class="badge bg-secondary">Đã hủy</span>';
                                ?>
                            </td>

                            <td>
                                <?php if($row['status'] == 'Pending'): ?>
                                    <a href="index.php?page=booking&action=cancel&id=<?php echo $row['booking_id']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Bạn có chắc chắn muốn hủy đơn đặt phòng này không?');">
                                       Hủy đơn
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">Không thể hủy</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="text-center">Bạn chưa có đơn đặt phòng nào.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <a href="index.php?page=home" class="btn btn-primary mt-3">Quay về trang chủ</a>
</div>

<?php include 'views/layout/footer.php'; ?>