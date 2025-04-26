<?php
// Kiểm tra đăng nhập (demo thôi, bạn có thể thay bằng kiểm tra thực tế)
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm nhân viên - Hệ thống giao hàng</title>
    <style>
        /* Thêm tiền tố .thêm-nv- để tránh xung đột với CSS của dashboard_admin.php */
        .thêm-nv-container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 500px;
            margin: 0 auto;
        }

        .thêm-nv-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #2c3e50;
        }

        .thêm-nv-form-group {
            margin-bottom: 20px;
        }

        .thêm-nv-form-group label {
            display: block;
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .thêm-nv-form-group input, .thêm-nv-form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            color: #2c3e50;
        }

        .thêm-nv-form-group input:focus, .thêm-nv-form-group select:focus {
            border-color: #3498db;
            outline: none;
        }

        .thêm-nv-button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .thêm-nv-button:hover {
            background-color: #2980b9;
        }

        .thêm-nv-back-button {
            text-align: center;
            margin-top: 15px;
        }

        .thêm-nv-back-button a {
            color: #2980b9;
            text-decoration: none;
            font-weight: bold;
        }

        .thêm-nv-back-button a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
<br> <br>
<div class="thêm-nv-container">
    <div class="thêm-nv-header">Thêm Nhân Viên</div>
    <form method="POST" action="process_add_employee.php">
        <div class="thêm-nv-form-group">
            <label for="name">Tên nhân viên</label>
            <input type="text" id="name" name="name" required placeholder="Nhập tên nhân viên">
        </div>

        <div class="thêm-nv-form-group">
            <label for="role">Chức vụ</label>
            <select id="role" name="role" required>
                <option value="">Chọn chức vụ</option>
                <option value="Shipper">Shipper</option>
                <option value="Quản lý kho">Quản lý kho</option>
                <option value="Điều phối viên">Điều phối viên</option>
            </select>
        </div>

        <div class="thêm-nv-form-group">
            <label for="status">Trạng thái</label>
            <select id="status" name="status" required>
                <option value="">Chọn trạng thái</option>
                <option value="Hoạt động">Hoạt động</option>
                <option value="Ngừng hoạt động">Ngừng hoạt động</option>
            </select>
        </div>

        <button type="submit" class="thêm-nv-button">Thêm Nhân Viên</button>
    </form>

    <div class="thêm-nv-back-button">
        <a href="dashboard_admin.php">Quay lại trang quản lý</a>
    </div>
</div>

</body>
</html>
