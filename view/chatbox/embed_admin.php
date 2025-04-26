<?php
/*
<!-- Nút nổi chat + số tin -->
<div id="admin-chat-toggle" onclick="toggleAdminChatbox()" 
     style="position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; background: #e74c3c; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 1000;">
    💬
    <span id="admin-unread-count" style="position: absolute; top: -5px; right: -5px; background: yellow; color: red; border-radius: 50%; padding: 4px 6px; font-size: 12px; display: none;">0</span>
</div>

<!-- Popup chatbox -->
<div id="admin-chatbox-popup" style="display:none; position: fixed; bottom: 90px; right: 20px; width: 320px; background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.2); z-index: 999;">
    <div style="background: #e74c3c; color: white; padding: 10px; font-weight: bold;">💬 Trò chuyện khách hàng</div>
    <div id="admin-chat-messages" style="height: 200px; overflow-y: auto; padding: 10px; font-size: 14px;"></div>
    <div style="padding: 10px; display: flex;">
        <input type="text" id="admin-chat-input" placeholder="Phản hồi..." style="flex: 1; padding: 6px; border-radius: 6px; border: 1px solid #ccc;">
        <button onclick="sendAdminMessage()" style="margin-left: 6px; padding: 6px 12px; background: #e74c3c; color: white; border: none; border-radius: 6px;">Gửi</button>
    </div>
</div>

<script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
<script>
const adminSocket = io("http://localhost:3000");
let unreadCount = 0;

// Nhận tin nhắn từ khách hàng
adminSocket.on("chat message", function(data) {
    const box = document.getElementById("admin-chat-messages");
    const div = document.createElement("div");
    div.innerHTML = `<strong style="color:#e74c3c">${data.user}:</strong> ${data.message}`;
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;

    // Nếu popup đang ẩn → hiện badge
    const popup = document.getElementById("admin-chatbox-popup");
    if (popup.style.display === "none") {
        unreadCount++;
        const badge = document.getElementById("admin-unread-count");
        badge.textContent = unreadCount;
        badge.style.display = "inline-block";
    }
});

function toggleAdminChatbox(){
    const popup = document.getElementById("admin-chatbox-popup");
    popup.style.display = (popup.style.display === "none") ? "block" : "none";

    // Reset badge khi mở
    if(popup.style.display === "block"){
        unreadCount = 0;
        document.getElementById("admin-unread-count").style.display = "none";
    }
}

function sendAdminMessage(){
    const input = document.getElementById("admin-chat-input");
    const msg = input.value.trim();
    if(msg !== ""){
        adminSocket.emit("chat message", {
            user: "Admin", // gắn thêm userId nếu cần
            message: msg
        });
        input.value = "";
    }
}
</script>
*/
?>

<!-- Popup chatbox Admin -->
<div id="admin-chatbox-popup" style="display:none; position: fixed; bottom: 90px; right: 20px; width: 320px; background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.2); z-index: 999;">
    <div style="background: #e74c3c; color: white; padding: 10px; font-weight: bold;">💬 Trò chuyện khách hàng</div>
    <div id="admin-chat-messages" style="height: 200px; overflow-y: auto; padding: 10px; font-size: 14px;"></div>
    <div style="padding: 10px; display: flex;">
        <input type="text" id="admin-chat-input" placeholder="Phản hồi..." style="flex: 1; padding: 6px; border-radius: 6px; border: 1px solid #ccc;">
        <button onclick="sendMessage()" style="margin-left: 6px; padding: 6px 12px; background: #e74c3c; color: white; border: none; border-radius: 6px;">Gửi</button>
    </div>
</div>

<!-- Nút nổi Admin -->
<div id="admin-chat-toggle" style="position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; background: #e74c3c; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 1000;">
    💬
    <span id="admin-unread-count" style="position: absolute; top: -5px; right: -5px; background: yellow; color: red; border-radius: 50%; padding: 4px 6px; font-size: 12px; display: none;">0</span>
</div>
