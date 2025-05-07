<?php
// payment_api.php

header('Content-Type: application/json');
include("model/ketnoi.php");
$p = new Ketnoi();
$con = $p->ketnoi();

$orderId = $_GET['madh'] ?? 0;

if ($orderId) {
    // Update trạng thái đã thanh toán
    $sql = "UPDATE donhang SET thanhtoan = 'Đã thanh toán' WHERE madh = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $orderId);
    if ($stmt->execute()) {
        echo "SUCCESS";
    } else {
        echo "FAIL";
    }
} else {
    echo "INVALID ORDER";
}
?>
