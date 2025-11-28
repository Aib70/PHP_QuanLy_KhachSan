<?php include 'views/layout/header.php'; ?>

<div class="container mt-4">
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold text-primary"><i class="fas fa-hotel me-2"></i>Quản Lý Danh Sách Phòng</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="index.php?page=rooms&action=create" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Thêm Phòng Mới
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Hình ảnh</th> <th>Số phòng</th>
                        <th>Loại phòng</th>
                        <th>Giá/Đêm</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center" width="150px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($rooms) && count($rooms) > 0): ?>
                        <?php foreach($rooms as $row): ?>
                            <tr>
                                <td class="text-center align-middle"><?php echo $row['room_id']; ?></td>
                                
                                <td class="text-center align-middle">
                                    <?php 
                                        // Nếu có tên ảnh thì dùng, không thì dùng ảnh mặc định
                                        $img_name = !empty($row['image']) ? $row['image'] : 'default.jpg';
                                    ?>
                                    <img src="assets/uploads/<?php echo $img_name; ?>" 
                                         alt="Room Img" 
                                         class="rounded border"
                                         style="width: 80px; height: 60px; object-fit: cover;">
                                </td>
                                
                                <td class="align-middle">
                                    <span class="fs-5 fw-bold text-dark"><?php echo $row['room_number']; ?></span>
                                </td>
                                
                                <td class="align-middle"><?php echo $row['type_name']; ?></td>
                                
                                <td class="align-middle fw-bold text-success">
                                    <?php echo number_format($row['price_per_night']); ?> VNĐ
                                </td>
                                
                                <td class="text-center align-middle">
                                    <?php 
                                        if($row['status'] == 'Available') 
                                            echo '<span class="badge bg-success">Trống</span>';
                                        else if($row['status'] == 'Booked') 
                                            echo '<span class="badge bg-danger">Đã đặt</span>';
                                        else 
                                            echo '<span class="badge bg-warning text-dark">Đang dọn</span>';
                                    ?>
                                </td>
                                
                                <td class="text-center align-middle">
                                    <a href="index.php?page=rooms&action=edit&id=<?php echo $row['room_id']; ?>" 
                                       class="btn btn-sm btn-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <a href="index.php?page=rooms&action=delete&id=<?php echo $row['room_id']; ?>" 
                                       class="btn btn-sm btn-danger ms-1" 
                                       onclick="return confirm('CẢNH BÁO: Bạn có chắc chắn muốn xóa phòng số <?php echo $row['room_number']; ?> không?');"
                                       title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-box-open fa-3x mb-3"></i><br>
                                Chưa có dữ liệu phòng nào. Hãy thêm phòng mới!
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>