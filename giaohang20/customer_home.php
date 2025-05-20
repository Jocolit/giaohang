<?php
session_start();
// if (!isset($_SESSION["dn"])) {
//     echo " <script>window.location.href='index.php'</script> ";
// }
include_once("control/c_dangnhap.php");
$p = new C_dangnhap();
$con = $p->get_lay1kh($_SESSION["tk"]);
if($con){
    $r = $con->fetch_assoc();
}else{
    echo 'Có lỗi';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Khách Hàng - Quản lý giao hàng</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f2f6fc;
            margin: 0;
        }

        header {
            background: #3498db;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav {
            background: #2980b9;
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 10px 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            padding: 30px;
            max-width: 1500px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .card h3 {
            margin-top: 0;
            color: #333;
        }

        footer {
            background: #ecf0f1;
            text-align: center;
            padding: 15px;
            color: #777;
            font-size: 14px;
        }

        .btn {
            background: #3498db;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn:hover {
            background: #2c80b4;
        }
    </style>
</head>
<body>

<header>
    <h2>Chào mừng, <?= $r["tenkh"] ?> 👋</h2>
</header>

<nav>
    <a href="customer_home.php">👤 Trang chủ</a>
    <a href="customer_home.php?taodh">📦 Tạo đơn hàng</a>
    <a href="customer_home.php?tracuu">🔍 Tra cứu đơn hàng</a>
    <a href="customer_home.php?lsdh">📜 Lịch sử mua hàng</a>
    <a href="customer_home.php?thongtin">👤 Tài khoản</a>
    <a href="customer_home.php?dangxuat">🚪 Đăng xuất</a>
</nav>

<?php
    if(isset($_REQUEST["taodh"]))
        include_once("view/taodonhang/index.php");
    elseif(isset($_REQUEST["tracuu"]))
        include_once("view/tracuudonhang/index.php");
    elseif(isset($_REQUEST["madh"]))
        include_once("view/thanh_toan/payment.php");
    else{

?>
<div class="container">

    <div class="card">
        <h3>Thông báo</h3>
        <p>Bạn có <strong>2</strong> đơn hàng đang chờ giao. Theo dõi trạng thái tại mục <strong>Tra cứu đơn hàng</strong>.</p>
    </div>

    <div class="card">
        <h3>Gợi ý</h3>
        <p>Bạn có thể dễ dàng tạo đơn hàng mới hoặc xem lại lịch sử các đơn trước.</p>
        <a href="customer_home.php?taodh" class="btn">Tạo đơn ngay</a>
    </div>

    <div class="card">
        <h3>Thông tin cá nhân</h3>
        <p><strong>Họ và tên:</strong> <?= $r["tenkh"] ?></p>
        <p><strong>Địa chỉ:</strong> <?= $r["diachi"] ?></p>
        <p><strong>Số điện thoại:</strong> <?= $r["sdt"] ?></p>
        <a href="edit_account.php" class="btn">Sửa thông tin cá nhân</a>
    </div>

</div>
<?php
    }
?>
<?php

    if(isset($_REQUEST["dangxuat"]))
        include_once("view/dangxuat/index.php");
?>

<footer>
    © 2025 Ứng dụng Giao Hàng | Bảo mật thông tin tuyệt đối
</footer>

<!-- Nút tư vấn nổi -->
<div id="chat-toggle" onclick="toggleChatbox()" 
     style="position: fixed; bottom: 20px; right: 20px; background: #007bff; color: white; border-radius: 50%; width: 60px; height: 60px; text-align: center; line-height: 60px; font-weight: bold; cursor: pointer; box-shadow: 0 0 10px rgba(0,0,0,0.2); z-index: 1000;">
    Liên hệ
</div>

<!-- Chatbox -->
<?php include_once("view/chatbox/embed_customer.php"); ?>

</body>
</html>
