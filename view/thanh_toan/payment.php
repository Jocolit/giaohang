<?php
session_start();
$orderId = $_GET['madh'] ?? 0;
if (!$orderId) {
    die('Không tìm thấy đơn hàng');
}

// Link Ngrok (bạn chỉ cần thay 1 dòng này mỗi lần restart Ngrok)
$ngrokUrl = "https://cf84-115-78-5-154.ngrok-free.app"; // <--- chỉnh lại URL thực tế của bạn
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh Toán Đơn Hàng</title>
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
    <script src="../../js/socket_payment.js"></script>
    <style>
        body { text-align: center; padding: 30px; font-family: 'Segoe UI', sans-serif; }
        img { width: 300px; margin: 20px auto; }
    </style>
</head>
<body>

<h2>Quét QR để thanh toán</h2>
<img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?= $ngrokUrl ?>/giaohang/view/thanh_toan/success.php?madh=<?= $orderId ?>" alt="QR Thanh Toán">

<p>Vui lòng quét QR bằng điện thoại</p>

<script>
const orderId = <?= $orderId ?>;
startFakePayment(orderId);  // nếu cần test auto thì dùng, nếu ko thì bỏ
</script>

</body>
</html>
