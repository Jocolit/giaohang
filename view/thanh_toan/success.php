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
    <style>
        body { text-align: center; margin-top: 100px; font-family: 'Segoe UI', sans-serif; }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<h2>Đã quét QR thành công!</h2>
<p>Vui lòng bấm nút dưới để xác nhận thanh toán:</p>

<button onclick="confirmPayment()">Xác nhận thanh toán</button>

<script>
const urlParams = new URLSearchParams(window.location.search);
const orderId = urlParams.get('madh');

function confirmPayment() {
    if (orderId) {
        sendPaymentSuccess(orderId);
        alert("Đã gửi xác nhận thanh toán!"); 
        // Có thể thêm: tự động chuyển trang khác sau khi bấm
        // window.location.href = "hoan-tat.html";
    }
}
</script>

</body>
</html>
