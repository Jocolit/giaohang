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
<?php
    $p = new C_dangnhap();
    $dstk = $p->get_dangnhap();
?>
<body>
<br> <br>
<div class="thêm-nv-container">
    <div class="thêm-nv-header">Thêm Nhân Viên</div>
    <form method="POST" action="">
        <!-- Tên nhân viên -->
        <div class="thêm-nv-form-group">
            <label for="name">Tên nhân viên</label>
            <input type="text" id="name" name="name" required placeholder="Nhập tên nhân viên">
        </div>

        <!-- Số điện thoại -->
        <div class="thêm-nv-form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" id="phone" name="phone" required placeholder="Nhập số điện thoại">
        </div>

        <!-- Chức vụ -->
        <div class="thêm-nv-form-group">
            <label for="role">Chức vụ</label>
            <select id="role" name="role" required>
                <option value="">Chọn chức vụ</option>
                <option value="1">Shipper</option>
                <option value="2">Điều phối viên</option>
                <option value="3">Quản lý kho</option>
                
            </select>
        </div>

        <!-- <div class="thêm-nv-form-group">
            <label for="status">Trạng thái</label>
            <select id="status" name="status" required>
                <option value="">Chọn trạng thái</option>
                <option value="Đang làm">Đang làm</option>
                <option value="Nghỉ">Nghỉ</option>
            </select>
        </div> -->

        <!-- Hình ảnh -->
        <div class="thêm-nv-form-group">
            <label for="image">Hình ảnh</label>
            <input type="file" id="image" name="image" accept="image/*" >
        </div>

        <!-- Tên đăng nhập -->
        <div class="thêm-nv-form-group">
            <label for="username">Tên đăng nhập</label>
            <input type="text" id="username" name="username" required placeholder="Nhập tên đăng nhập">
        </div>

        <!-- Mật khẩu -->
        <div class="thêm-nv-form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu">
        </div>

        <button type="submit" class="thêm-nv-button" name="btnthem">Thêm Nhân Viên</button>
    </form>

    <div class="thêm-nv-back-button">
        <a href="dashboard_admin.php">Quay lại trang quản lý</a>
    </div>
</div>

</body>
</html>

<?php
        include_once("control/c_dangnhap.php");
        $p = new C_dangnhap();
        $dstk = $p->get_dangnhap();
        
    if(isset($_REQUEST["btnthem"])){
        
        $tendn = $_REQUEST["username"];
        $mk = $_REQUEST["password"];
        $mota = "Nhân viên";
        $loaitk = 2;
        if($dstk){
            while($r = $dstk->fetch_assoc()){
                if($r["tendn"] === $tendn){
                    echo "<script>alert('Tên đăng nhập đã tồn tại');</script>";
                    return;
                }
            }
        }
        $matk = $p->get_dangky($tendn, $mk, $mota, $loaitk);
        if($matk){
            $ten = $_REQUEST["name"];
            $sdt = $_REQUEST["phone"];
            $hinh = $_REQUEST["image"];
            $trangthai = "Đang làm";
            $cv = $_REQUEST["role"];
            $rs = $p->get_themnv($ten, $sdt, $hinhanh, $trangthai, $matk, $cv);
            if($rs){
                echo "<script>alert('Thêm nhân viên thành công');</script>";
                echo '<script>window.location.href="dashboard_admin.php?qlnv"</script>';
            }else{
                echo "<script>alert('Lỗi');</script>";
            }
        }
        
    }
?>