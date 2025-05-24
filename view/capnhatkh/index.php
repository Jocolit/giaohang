<?php
// Kiểm tra đăng nhập (demo thôi, bạn có thể thay bằng kiểm tra thực tế)
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khách hàng - Hệ thống giao hàng</title>
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
    include_once("control/c_dangnhap.php");
    $p = new C_dangnhap();
    if(isset($_REQUEST["matk"])){
        $suakh = $_REQUEST["matk"];
        $kh = $p->get_lay1kh($suakh);  
        if($kh)
            $r = $kh->fetch_assoc();   
    }
?>
<body>
<br> <br>
<div class="thêm-nv-container">
    <div class="thêm-nv-header">Cập nhật thông tin Cá Nhân</div>

    <form method="POST" action="">
        <!-- Tên nhân viên -->
        <div class="thêm-nv-form-group">
            <label for="name">Họ và tên</label>
            <input type="text" id="name" name="name" required value="<?= $r["tenkh"]?>">
<div id="error-name" style="color:red; font-size: 14px; margin-top: 4px;"></div>

        </div>

        <!-- Số điện thoại -->
        <div class="thêm-nv-form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" id="phone" name="phone" required value="<?= $r["sdt"]?>">
<div id="error-phone" style="color:red; font-size: 14px; margin-top: 4px;"></div>

        </div>
        <!-- địa chỉ -->
        <div class="thêm-nv-form-group">
            <label for="dc">Địa chỉ</label>
            <input type="text" id="dc" name="dc" required value="<?= $r["diachi"]?>">
        </div>

        <!-- Hình ảnh -->
        <!-- <div class="thêm-nv-form-group">
            <label for="image">Hình ảnh</label>
            <input type="file" id="image" name="image" accept="image/*" >
        </div> -->

        

        <button type="submit" class="thêm-nv-button" name="btnsua">Cập nhật</button>
    </form>

    <div class="thêm-nv-back-button">
        <a href="customer_home.php">Quay lại trang chủ khách hàng</a>
    </div>
</div>
<script>
const nameInput = document.getElementById("name");
const phoneInput = document.getElementById("phone");

const nameError = document.getElementById("error-name");
const phoneError = document.getElementById("error-phone");

const nameRegex = /^([A-ZÀ-Ỹ][a-zà-ỹ]+)(\s[A-ZÀ-Ỹ][a-zà-ỹ]+)*$/u;
const phoneRegex = /^0\d{9}$/;

// Kiểm tra tên
nameInput.addEventListener("input", () => {
    const value = nameInput.value.trim();
    if (!nameRegex.test(value)) {
        nameError.textContent = "Tên phải viết hoa chữ cái đầu mỗi từ (VD: Nguyễn Văn A)";
    } else {
        nameError.textContent = "";
    }
});

// Kiểm tra số điện thoại
phoneInput.addEventListener("input", () => {
    const value = phoneInput.value.trim();
    if (!phoneRegex.test(value)) {
        phoneError.textContent = "Số điện thoại phải có đúng 10 số và bắt đầu bằng số 0";
    } else {
        phoneError.textContent = "";
    }
});
</script>

</body>
</html>

<?php
    if(isset($_REQUEST["btnsua"])){
        $makh = $r["makh"];
        $ten = $_REQUEST["name"];
        $sdt = $_REQUEST["phone"];
        $dc = $_REQUEST["dc"];
        // $hinh = $_REQUEST["image"];

        $capnhat = $p->get_capnhatkh($makh, $ten, $sdt, $dc);
        if($capnhat){
            echo "<script>alert('Cập nhật thông tin cá nhân thành công');</script>";
            echo '<script>window.location.href="customer_home.php"</script>';
        }
    }
?>