<?php
// File: view/thanh_toan/api_payment.php
session_start();

// Để cho phép request từ bên ngoài nếu bạn cần
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['madh'] ?? 0;

    if (!$orderId) {
        http_response_code(400);
        echo json_encode(["error" => "Thiếu mã đơn hàng"]);
        exit();
    }

    ?>

    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>Xử lý thanh toán</title>
        <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
        <script src="../../js/socket_payment.js"></script>
    </head>
    <body>

    <script>
        const orderId = <?= $orderId ?>;
        sendPaymentSuccess(orderId);

        // Sau khi gửi tín hiệu xong, trả JSON cho client
        fetch("", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ success: true })
        });
    </script>

    </body>
    </html>

<?php
} else {
    http_response_code(405);
    echo json_encode(["error" => "Phương thức không hợp lệ"]);
}
?>
