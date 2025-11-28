<?php include 'views/layout/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Quản Lý Đặt Phòng (Admin)</h2>
        <a href="index.php?page=rooms" class="btn btn-outline-primary">Quản lý Phòng</a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Phòng</th>
                        <th>Ngày Check-in/out</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($bookings as $row): ?>
                        <tr>
                            <td>#<?php echo $row['booking_id']; ?></td>
                            <td>
                                <strong><?php echo $row['username']; ?></strong><br>
                                <small><?php echo $row['full_name']; ?></small>
                            </td>
                            <td><span class="badge bg-info"><?php echo $row['room_number']; ?></span></td>
                            <td>
                                <?php echo date('d/m', strtotime($row['check_in_date'])); ?> - 
                                <?php echo date('d/m', strtotime($row['check_out_date'])); ?>
                            </td>
                            <td class="fw-bold"><?php echo number_format($row['total_price']); ?> đ</td>
                            <td>
                                <?php 
                                    if($row['status'] == 'Pending') echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                    elseif($row['status'] == 'Confirmed') echo '<span class="badge bg-success">Đã duyệt</span>';
                                    else echo '<span class="badge bg-secondary">Đã hủy</span>';
                                ?>
                            </td>
                            <td>
                                <?php if($row['status'] == 'Pending'): ?>
                                    <a href="index.php?page=admin_booking_update&id=<?php echo $row['booking_id']; ?>&status=Confirmed" 
                                       class="btn btn-sm btn-success">Duyệt</a>
                                    
                                    <a href="index.php?page=admin_booking_update&id=<?php echo $row['booking_id']; ?>&status=Cancelled" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Hủy đơn này?');">Hủy</a>
                                <?php else: ?>
                                    <span class="text-muted small">Đã xử lý</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>