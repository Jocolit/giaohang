const adminSocket = io("http://localhost:3000");

let currentRoomId = null;
let currentCustomerName = null;
let chatDetailVisible = false;

// Khi mở danh sách khách
function openAdminChatbox() {
    document.getElementById("admin-badge").style.display = "none";
    document.getElementById("admin-chatbox-full").style.display = "block";

    fetch("get_chat_users.php")
        .then(response => response.json())
        .then(users => {
            const list = document.getElementById("chat-conversation-list");
            list.innerHTML = "";

            if (users.length === 0) {
                document.getElementById("no-conversation").style.display = "block";
                return;
            }
            document.getElementById("no-conversation").style.display = "none";

            users.forEach(user => {
                const item = document.createElement("div");
                item.style.padding = "10px";
                item.style.borderBottom = "1px solid #ddd";
                item.style.cursor = "pointer";
                item.innerHTML = `
          <div><strong>${user.user}</strong></div>
          <div style="font-size:12px;color:#888;">(${user.room})</div>
        `;
                item.addEventListener("click", () => {
                    openChatDetail(user.room, user.user);
                });
                list.appendChild(item);
            });
        });
}

// Khi mở chi tiết 1 khách
function openChatDetail(roomId, customerName) {
    document.getElementById("chat-detail-popup").style.display = "block";
    chatDetailVisible = true;

    if (currentRoomId && currentRoomId !== String(roomId)) { // **Sửa đổi:** So sánh với chuỗi
        adminSocket.emit('leave room', { room: currentRoomId });
    }

    currentRoomId = String(roomId); // **Sửa đổi:** Gán currentRoomId là chuỗi
    currentCustomerName = customerName;

    adminSocket.emit("join room", { room: currentRoomId });

    const box = document.getElementById("chat-detail-messages");
    box.innerHTML = "<i>Đang tải hội thoại...</i>";
    // Thêm đoạn này để xóa thông báo
    const chatItem = Array.from(document.getElementById("chat-conversation-list").children)
        .find(item => item.innerHTML.includes(`(${roomId})`));
    if (chatItem && chatItem.querySelector("span")) {
        chatItem.querySelector("span").remove();
    }
}

// Khi nhận lịch sử chat
adminSocket.on("history", (messages) => {
    const box = document.getElementById("chat-detail-messages");
    box.innerHTML = "";
    messages.forEach(msg => {
        const div = document.createElement("div");
        const isSender = (msg.user === "Quản lý");
        div.className = `message ${isSender ? 'sent' : 'received'}`;
        div.innerText = msg.message;
        box.appendChild(div);
    });
    box.scrollTop = box.scrollHeight;
});


adminSocket.on("chat message", (data) => {
    if (document.getElementById("admin-chatbox-full").style.display !== "block" || currentRoomId !== data.room) {
        document.getElementById("admin-badge").style.display = "inline-block";

        // Thêm badge như cũ
        const chatItem = Array.from(document.getElementById("chat-conversation-list").children)
            .find(item => item.innerHTML.includes(`(${data.room})`));
        if (chatItem && !chatItem.querySelector("span")) {
            const badge = document.createElement("span");
            badge.innerText = "!";
            badge.style.backgroundColor = "red";
            badge.style.color = "white";
            badge.style.borderRadius = "50%";
            badge.style.padding = "2px 5px";
            badge.style.marginLeft = "5px";
            chatItem.appendChild(badge);
        }
    } else {
        const box = document.getElementById("chat-detail-messages");
        const div = document.createElement("div");
        const isSender = (data.user === "Quản lý");
        div.className = `message ${isSender ? 'sent' : 'received'}`;
        div.innerText = data.message;
        box.appendChild(div);
        box.scrollTop = box.scrollHeight;
    }
});

adminSocket.on('connect', () => {
    console.log('Admin client connected');
    if (currentRoomId) {
        adminSocket.emit("join room", { room: currentRoomId });
        console.log(`Admin re-joined room: ${currentRoomId}`);
        // Có thể load lại lịch sử chat sau khi kết nối lại nếu cần
    }
});

// Gửi tin nhắn
function sendAdminMessage() {
    const input = document.getElementById("admin-chat-input");
    const msg = input.value.trim();
    if (msg !== "" && currentRoomId) {
        adminSocket.emit("chat message", {
            room: currentRoomId,
            user: "Quản lý",
            message: msg
        });
        input.value = "";
    }
}
document.getElementById("admin-chat-input").addEventListener("keypress", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        sendAdminMessage();
    }
});

// Đóng popup
function closeAdminChatbox() {
    document.getElementById("admin-chatbox-full").style.display = "none";
}

function closeChatDetail() {
    document.getElementById("chat-detail-popup").style.display = "none";
    chatDetailVisible = false;
}
adminSocket.on("payment update", (data) => {
    alert(`Đơn hàng ${data.orderId} đã được thanh toán!`);
});

// ✅ Khi có tín hiệu từ server yêu cầu cập nhật danh sách người dùng
adminSocket.on("update user list", () => {
    const chatBox = document.getElementById("admin-chatbox-full");
    if (chatBox && chatBox.style.display === "block") {
        openAdminChatbox();
    }
});