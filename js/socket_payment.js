const socketPayment = io('https://b5e0-115-73-214-107.ngrok-free.app'); // Dùng luôn Ngrok URL nhé

function startFakePayment(orderId) {
    console.log('Đang chờ thanh toán đơn hàng:', orderId);

    // **Nếu muốn tự động redirect, thì mở ra**
    // setTimeout(() => {
    //     window.location.href = `success.php?madh=${orderId}`;
    // }, 5000);
}

function sendPaymentSuccess(orderId) {
    console.log('Gửi tín hiệu thanh toán thành công:', orderId);
    socketPayment.emit('payment success', { orderId });
}