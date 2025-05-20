const socket = io("http://localhost:3000");

const customerId = String(currentCustomerId);
const customerName = currentUserName;
let chatboxVisible = false;

let pendingMessages = [];

socket.emit("join room", { room: customerId });

// Load lịch sử chat
socket.on("history", (messages) => {
    const box = document.getElementById("chat-messages");
    box.innerHTML = "";
    messages.forEach(msg => {
        const div = document.createElement("div");
        const isSender = (msg.user === customerName);
        div.className = `message ${isSender ? 'sent' : 'received'}`;
        div.innerText = msg.message;
        box.appendChild(div);
    });
    box.scrollTop = box.scrollHeight;
});



socket.on("chat message", (data) => {
    if (customerId === data.room) {
        const box = document.getElementById("chat-messages");
        const div = document.createElement("div");
        const isSender = (data.user === customerName);
        div.className = `message ${isSender ? 'sent' : 'received'}`;
        div.innerText = data.message;

        if (!chatboxVisible) {
            pendingMessages.push(data);
            const chatToggle = document.getElementById("chat-toggle");
            chatToggle.innerText = "💬 (" + (chatToggle.innerText.includes("(") ? parseInt(chatToggle.innerText.split("(")[1].split(")")[0]) + 1 : 1) + ") Liên hệ";
            chatToggle.style.backgroundColor = "green";
            document.getElementById("customer-badge").style.display = "inline-block";

        } else {
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
document.getElementById("chat-input").addEventListener("keypress", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        sendMessage();
    }
});

// Toggle chatbox
function toggleChatbox() {
    document.getElementById("customer-badge").style.display = "none";

    const popup = document.getElementById("chatbox-popup");
    popup.style.display = (popup.style.display === "none") ? "block" : "none";
    chatboxVisible = (popup.style.display === "block");
    if (chatboxVisible) {
        const chatToggle = document.getElementById("chat-toggle");
        chatToggle.innerText = "Liên hệ";
        chatToggle.style.backgroundColor = "#007bff";

        // Hiển thị các tin nhắn chờ
        const box = document.getElementById("chat-messages");
        pendingMessages.forEach(msg => {
            const div = document.createElement("div");
            const isSender = (msg.user === customerName);
            div.className = `message ${isSender ? 'sent' : 'received'}`;
            div.innerText = msg.message;
            box.appendChild(div);
        });

        box.scrollTop = box.scrollHeight;
        pendingMessages = [];
    }

}
socket.on("payment update", (data) => {
    alert(`Đơn hàng ${data.orderId} đã thanh toán thành công!`);
});