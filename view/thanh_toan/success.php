<?php
session_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh Toán Thành Công</title>
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
    <script src="../../js/socket_payment.js"></script>
</head>
<body>

<h2 style="text-align: center; margin-top: 100px;">Thanh toán thành công!</h2>

<script>
const urlParams = new URLSearchParams(window.location.search);
const orderId = urlParams.get('madh');

if (orderId) {
    sendPaymentSuccess(orderId);
}
</script>

</body>
</html>
