const socket = io("http://localhost:3000");

const customerId = String(currentCustomerId);
const customerName = currentUserName;
let chatboxVisible = false;

socket.emit("join room", { room: customerId });

// Load lịch sử chat
socket.on("history", (messages) => {
    const box = document.getElementById("chat-messages");
    box.innerHTML = "";
    messages.forEach(msg => {
        const div = document.createElement("div");
        div.innerHTML = `<strong>${msg.user}:</strong> ${msg.message}`;
        box.appendChild(div);
    });
    box.scrollTop = box.scrollHeight;
});

// Khi nhận tin nhắn mới
// socket.on("chat message", (data) => {
//     console.log("Khách nhận tin nhắn:", data);
//     console.log("customerId:", customerId);
//     console.log("data.room:", data.room);
//     if (customerId === data.room) { // **Sửa đổi:** So sánh chuỗi với chuỗi (===)
//         const box = document.getElementById("chat-messages");
//         const div = document.createElement("div");
//         div.innerHTML = `<strong>${data.user}:</strong> ${data.message}`;
//         box.appendChild(div);
//         box.scrollTop = box.scrollHeight;
//     } else {
//         console.log("Tin nhắn mới đến từ room khác:", data.room);
//     }
// });
socket.on("chat message", (data) => {
    if (customerId === data.room) {
        if (!chatboxVisible) {
            const chatToggle = document.getElementById("chat-toggle");
            chatToggle.innerText = "💬 (" + (chatToggle.innerText.includes("(") ? parseInt(chatToggle.innerText.split("(")[1].split(")")[0]) + 1 : 1) + ") Tư Vấn";
            chatToggle.style.backgroundColor = "green";
        } else {
            // Hiển thị tin nhắn như bình thường
            const box = document.getElementById("chat-messages");
            const div = document.createElement("div");
            div.innerHTML = `<strong>${data.user}:</strong> ${data.message}`;
            box.appendChild(div);
            box.scrollTop = box.scrollHeight;
        }
    }
});

socket.on('connect', () => {
    console.log('Customer client connected');
    socket.emit("join room", { room: customerId });
    console.log(`Customer joined room: ${customerId}`);
    // Có thể load lại lịch sử chat sau khi kết nối lại nếu cần
});


// Gửi tin nhắn
function sendMessage() {
    const input = document.getElementById("chat-input");
    const msg = input.value.trim();
    if (msg !== "") {

        socket.emit("chat message", {
            room: customerId,
            user: customerName,
            message: msg
        });
        input.value = "";
    }
}

// Toggle chatbox
function toggleChatbox() {
    const popup = document.getElementById("chatbox-popup");
    popup.style.display = (popup.style.display === "none") ? "block" : "none";
    chatboxVisible = (popup.style.display === "block");
    if (chatboxVisible) {
        const chatToggle = document.getElementById("chat-toggle");
        chatToggle.innerText = "Tư Vấn";
        chatToggle.style.backgroundColor = "#007bff";
    }
}
socket.on("payment update", (data) => {
    alert(`Đơn hàng ${data.orderId} đã thanh toán thành công!`);
});