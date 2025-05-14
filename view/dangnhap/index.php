<?php
// session_start();
include("control/c_dangnhap.php");
$p = new C_dangnhap();

if (isset($_REQUEST["btndn"])) {
    $tendn = $_REQUEST["tendn"];
    $mk = $_REQUEST["password"];
    $con = $p->get_dangnhap($tendn, $mk);
    if ($con == true) {
        $r = $con->fetch_assoc();
        $loaitk = $r["loaitk"];
        $matk = $r["matk"];
        $_SESSION["dn"] = 1;
        $_SESSION["loaitk"] = $r["loaitk"];
        if($loaitk == 3){
            $_SESSION["tk"] = $r["matk"];
            echo "<script>alert('Đăng nhập thành công');</script>";
            echo " <script>window.location.href='customer_home.php'</script>";
        }elseif($loaitk == 1){
            $_SESSION["tk"] = $r["matk"];
            echo "<script>alert('Đăng nhập thành công');</script>";
            echo " <script>window.location.href='dashboard_admin.php'</script>";
        }elseif($loaitk == 2){
            $conn = $p->get_nhanvien($matk);
            $rr = $conn ->fetch_assoc();
            $macv = $rr["macv"];
            $_SESSION["macv"] = $rr["macv"];
            if($macv == 1){
                $_SESSION["nv"] = $rr["manv"];
                echo "<script>alert('Đăng nhập thành công');</script>";
                echo " <script>window.location.href='dashboard_shipper.php'</script>";
            }elseif($macv == 2){
                echo "<script>alert('Đăng nhập thành công');</script>";
                echo " <script>window.location.href='dashboard_dieuphoi.php'</script>";
            }elseif($macv == 3){
                echo "<script>alert('Đăng nhập thành công');</script>";
                echo " <script>window.location.href='dashboard_kho.php'</script>";
            }
        }
        
        else{
            echo 'Lỗi gì đó';
        } 
    } else {
        echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Quản lý giao hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #2980b9, #6dd5fa);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .login-box {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 400px;
            max-width: 90%;
        }
        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        .login-box input[type="text"]:focus,
        .login-box input[type="password"]:focus {
            border-color: #2980b9;
            outline: none;
        }
        .login-box input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #2980b9;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .login-box input[type="submit"]:hover {
            background: #2573a6;
        }
        .login-box .error {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px;
        }
        .login-box .forgot {
            text-align: center;
            margin-top: 10px;
        }
        .login-box .forgot a {
            color: #2980b9;
            text-decoration: none;
            font-size: 14px;
        }
        .login-box .signup-link {
            text-align: center;
            margin-top: 15px;
        }
        .login-box .signup-link a {
            color: #2980b9;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Đăng nhập</h2>

    <form method="post">
        <input type="text" name="tendn" placeholder="Tài khoản" required autofocus>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <input type="submit" value="Đăng nhập" name="btndn">
    </form>

    <!-- <div class="forgot">
        <a href="#">Quên mật khẩu?</a>
    </div> -->
    <div class="signup-link">
        <a href="index.php?dangky">Đã chưa có tài khoản? Đăng ký</a>
    </div>
</div>

</body>
</html>
