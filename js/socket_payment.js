const socketPayment = io('http://localhost:3000'); // Dùng luôn Ngrok URL nhé

function startFakePayment(orderId) {
    console.log('Đang chờ thanh toán đơn hàng:', orderId);

    // **Nếu muốn tự động redirect, thì mở ra**
    setTimeout(() => {
        window.location.href = `success.php?madh=${orderId}`;
    }, 5000);
}

function sendPaymentSuccess(orderId) {
    console.log('Gửi tín hiệu thanh toán thành công:', orderId);
    socketPayment.emit('payment success', { orderId });
}