<?php

include_once("control/c_dangnhap.php");
require_once("libs/phpqrcode/qrlib.php");
$p = new C_dangnhap();

if (!isset($_GET['madh'])) {
    die("Thiếu mã đơn hàng");
}

$madh = intval($_GET['madh']);

// Lấy thông tin đơn hàng từ DB
$con = $p->get_dsdonhang($madh);
if ($con) {
    $order = $con->fetch_assoc();
    $tongtien = $order["shipping_fee"] + $order["thuho"];
} else {
    die("Đơn hàng không tồn tại");
}

// Tạo dữ liệu QR code (ví dụ: bạn có thể tùy chỉnh theo nội dung thanh toán thực tế)
$qrData = "PAYMENT|ORDER_ID:$madh|AMOUNT:".$tongtien."|ACCOUNT:2403032003|BANK:Ngân hàng ABC";

// Thư mục lưu file QR code tạm
$tmpDir = "tmp/";
if (!file_exists($tmpDir)) {
    mkdir($tmpDir, 0777, true);
}
$filename = $tmpDir . "order_" . $madh . ".png";

// Tạo QR code
QRcode::png($qrData, $filename, QR_ECLEVEL_L, 6);

if (isset($_POST['pay'])) {
    // Cập nhật trạng thái đơn hàng sang "Đã thanh toán"
    $p->get_capnhat_thanhtoan($madh, "Đã thanh toán");

    // Gửi yêu cầu tới server Node.js để phát sự kiện realtime
    $ch = curl_init("http://localhost:3000/payment_update");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["orderId" => $madh]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    echo "<script>alert('Thanh toán thành công!'); window.location.href='customer_home.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Thanh toán đơn hàng #<?= $madh ?></title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f7f7f7; padding: 20px; }
        .container { max-width: 400px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.1); text-align: center; }
        img { width: 250px; height: 250px; }
        button { margin-top: 20px; padding: 12px 25px; background: #3498db; border: none; color: white; font-size: 18px; border-radius: 6px; cursor: pointer; }
        button:hover { background: #2980b9; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thanh toán đơn hàng #<?= $madh ?></h2>
        <p>Số tiền: <strong><?= number_format($tongtien, 0, ",", ".") ?> VNĐ</strong></p>
        <p>Vui lòng quét mã QR dưới đây để thanh toán chuyển khoản:</p>
        <img src="tmp/order_<?= $madh ?>.png" alt="QR Code thanh toán" />

        <form method="post">
            <button type="submit" name="pay">Thanh toán thành công</button>
        </form>
    </div>
</body>
</html>
