const adminSocket = io("http://localhost:3000");
let unreadCount = 0;

adminSocket.on("chat message", function(data) {
    // Hiển thị popup nếu đang mở
    const box = document.getElementById("admin-chat-messages");
    const div = document.createElement("div");
    div.innerHTML = `<strong style="color:#e74c3c">${data.user}:</strong> ${data.message}`;
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;

    // Nếu popup đang ẩn → tăng số thông báo
    const popup = document.getElementById("admin-chatbox-popup");
    if (popup.style.display === "none") {
        unreadCount++;
        const badge = document.getElementById("admin-unread-count");
        badge.textContent = unreadCount;
        badge.style.display = "inline-block";
    }
});

function toggleAdminChatbox() {
    const popup = document.getElementById("admin-chatbox-popup");
    popup.style.display = (popup.style.display === "none") ? "block" : "none";

    // Nếu vừa mở → reset badge
    if (popup.style.display === "block") {
        unreadCount = 0;
        document.getElementById("admin-unread-count").style.display = "none";
    }
}

function sendAdminMessage() {
    const input = document.getElementById("admin-chat-input");
    const msg = input.value.trim();
    if (msg !== "") {
        adminSocket.emit("chat message", {
            user: "Admin",
            message: msg
        });
        input.value = "";
    }
}