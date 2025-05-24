<?php

include_once("control/c_dangnhap.php");

require_once __DIR__ . '/../../vendor/autoload.php';  // Đường dẫn tới autoload composer

use PayOS\PayOS;
$p = new C_dangnhap();

if (!isset($_GET['madh'])) {
    die("Thiếu mã đơn hàng");
}

$madh = intval($_GET['madh']);

// Lấy thông tin đơn hàng từ DB
$con = $p->get_dsdonhang($madh);
if ($con) {
    $order = $con->fetch_assoc();
    $tongtien = (int)$order["shipping_fee"];
} else {
    die("Đơn hàng không tồn tại");
}

// Khởi tạo payOS
// Keep your PayOS key protected by including it by an env variable
$payOSClientId = '7c1b81a5-f650-44c2-a314-84b13c2f581b';
$payOSApiKey = '124b17d0-2842-434f-b46c-f4cbefeb86a7';
$payOSChecksumKey = '6f4032c05401e02142dc479c99017c12084c6be663b9b2b281d4b913ad3ced7e';

$payOS = new PayOS($payOSClientId, $payOSApiKey, $payOSChecksumKey);

// Tạo payment link
$request = [
    'orderCode' => $madh,
    'amount' => $tongtien,
    'description' => "Thanh toán đơn hàng #$madh",
    'returnUrl' => 'http://localhost:8088/giaohang/customer_home.php?tracuu',  // Đổi URL phù hợp
    'cancelUrl' => 'https://yourwebsite.com/cancel.php',   // Đổi URL phù hợp
];

try {
    $response = $payOS->createPaymentLink($request);
    $checkoutUrl = $response['checkoutUrl'];
} catch (Exception $e) {
    die("Lỗi tạo link thanh toán: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Thanh toán đơn hàng #<?= htmlspecialchars($madh) ?></title>
    <style>
        /* body { font-family: 'Segoe UI', sans-serif; background: #f7f7f7; padding: 20px; } */
        .container-payment { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.1); text-align: center; }
        #payos-embedded {
        width: 100%;       /* Để rộng 100% vùng cha */
        max-width: 500px;  /* Giới hạn tối đa (bạn chỉnh theo ý muốn) */
        height: 550px;     /* Chiều cao lớn hơn để hiển thị QR to */
        margin: auto;      /* Canh giữa */
        overflow: visible; /* Không hiển thị thanh cuộn */
        border: none;      /* Nếu có viền thì bỏ */
        }


    </style>
</head>
<body>
    <div class="container-payment">
        <h2>Thanh toán đơn hàng #<?= htmlspecialchars($madh) ?></h2>
        <p>Số tiền: <strong><?= number_format($tongtien, 0, ",", ".") ?> VNĐ</strong></p>

        <div id="payos-embedded"></div>

        <script src="https://cdn.payos.vn/payos-checkout/v1/stable/payos-initialize.js"></script>
        <script>
          const payOSConfig = {
            RETURN_URL: "http://localhost:8088/giaohang/customer_home.php?tracuu",
            ELEMENT_ID: "payos-embedded",
            CHECKOUT_URL: "<?= $checkoutUrl ?>",
            embedded: true,
            onSuccess: (event) => {
              alert("Thanh toán thành công!");
              // Có thể redirect hoặc xử lý khác ở đây
              <?php
                $p->get_capnhat_thanhtoan($madh, "Đã thanh toán");
              ?>
              window.location.href = "customer_home.php";

            },
            onCancel: (event) => {
              alert("Bạn đã hủy thanh toán.");
            },
            onExit: (event) => {
              console.log("Người dùng thoát form thanh toán.");
            },
          };

          const { open, exit } = PayOSCheckout.usePayOS(payOSConfig);
          open();
          const waitIframe = setInterval(() => {
            const iframe = document.querySelector('#payos-embedded iframe');
            if (iframe) {
                iframe.style.width = '100%';
                iframe.style.height = '500px';  // Phù hợp với div cha
                clearInterval(waitIframe);
            }
            }, 100);

        </script>

    </div>
</body>
</html>
