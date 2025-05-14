<?php
// session_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - Quản lý giao hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #27ae60, #a2f4c4);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .register-box {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 450px;
            max-width: 95%;
        }
        .register-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
        }
        .register-box input[type="text"],
        .register-box input[type="password"],
        .register-box input[type="tel"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        .register-box input[type="text"]:focus,
        .register-box input[type="password"]:focus,
        .register-box input[type="tel"]:focus {
            border-color: #27ae60;
            outline: none;
        }
        .register-box input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .register-box input[type="submit"]:hover {
            background: #1f9d51;
        }
        .register-box .login-link {
            text-align: center;
            margin-top: 15px;
        }
        .register-box .login-link a {
            color: #27ae60;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>

<?php
    if(isset($_REQUEST["btndk"])){
        include_once("control/c_dangnhap.php");
        $p = new C_dangnhap();
        $con = $p->get_lay1kh();

        $loaitk = 3; // mã loại tk của Khách hàng 
        $tendn = $_REQUEST["dktendn"];
        $sdt = $_REQUEST["dksdt"];
        $mk = $_REQUEST["dkmk"];
        $nl = $_REQUEST["dknhaplai"];
        $mota = "Sử dụng cho khách hàng";

        while($r = $con->fetch_assoc()){
            if($r["tendn"] === $tendn || $r["sdt"] === $sdt){
                echo "<script>alert('Tài khoản đã tồn tại');</script>";
                return;
            }
        }

        if($mk != $nl){
            echo "<script>alert('Mật khẩu không khớp');</script>";
            return;
        }else{
            $rs = $p->get_dangky($tendn, $mk, $mota, $loaitk);
            if($rs){
                $tenkh = $_REQUEST["dkten"];
                $diachi = $_REQUEST["dkdiachi"];
                $hinhanh = $_REQUEST["dkhinhanh"];

                $p->get_taokhachhang($tenkh, $sdt, $diachi, $hinhanh, $rs);
                echo "<script>alert('Đăng ký thành công');</script>";
                echo '<script>window.location.href="index.php?dangnhap"</script>';
            }
            else
            echo "<script>alert('Thất bại');</script>";
                
        }

    }
?>
<body>

<div class="register-box">
    <h2>Đăng Ký Tài Khoản</h2>

    <form action="" method="post">
        <input type="text" name="dktendn" placeholder="Tên đăng nhập" required>
        <input type="password" name="dkmk" placeholder="Mật khẩu" required>
        <input type="password" name="dknhaplai" placeholder="Nhập lại mật khẩu" required>
        <input type="text" name="dkten" placeholder="Họ và tên" required>
        <input type="tel" name="dksdt" placeholder="Số điện thoại" required>
        <input type="text" name="dkdiachi" placeholder="Địa chỉ" required>
        <input type="text" name="dkhinhanh" placeholder="Hình ảnh" required>
        <input type="submit" value="Đăng Ký" name="btndk">
    </form>

    <div class="login-link">
        <a href="index.php?dangnhap">Đã có tài khoản? Đăng nhập</a>
    </div>
</div>

</body>
</html>
