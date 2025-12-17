<?php include 'views/layout/header.php'; ?>
<div class="container mt-4">
    <div class="row mb-3 align-items-center">
        <div class="col-6">
            <h2 class="text-primary"><i class="fas fa-users-cog"></i> Quản Lý Nhân Viên</h2>
        </div>
        <div class="col-6 text-end">
            <a href="index.php?page=staff&action=create" class="btn btn-primary"><i class="fas fa-user-plus"></i> Thêm Nhân Viên</a>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Họ và Tên</th>
                        <th>Chức vụ</th> <th>SĐT</th>
                        <th>Tài khoản</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($staffs as $row): ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td class="fw-bold"><?php echo $row['full_name']; ?></td>
                        <td>
                            <span class="badge bg-info text-dark"><?php echo isset($row['position']) ? $row['position'] : 'Nhân viên'; ?></span>
                        </td>
                        <td><?php echo isset($row['phone']) ? $row['phone'] : '-'; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td class="text-center">
                            <a href="index.php?page=staff&action=show&id=<?php echo $row['user_id']; ?>" class="btn btn-sm btn-info text-white" title="Chi tiết"><i class="fas fa-eye"></i></a>
                            <a href="index.php?page=staff&action=edit&id=<?php echo $row['user_id']; ?>" class="btn btn-sm btn-warning" title="Sửa"><i class="fas fa-edit"></i></a>
                            <a href="index.php?page=staff&action=delete&id=<?php echo $row['user_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa nhân viên này?');" title="Xóa"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>