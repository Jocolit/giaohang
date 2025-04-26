/*
const socket = io("http://localhost:3000"); // ⚠️ nhớ thay đổi khi deploy

socket.on("chat message", function(data) {
    const box = document.getElementById("chat-messages");
    const div = document.createElement("div");
    div.innerHTML = `<strong style="color:#007bff">${data.user}:</strong> ${data.message}`;
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;
});

function sendMessage() {
    const input = document.getElementById("chat-input");
    const msg = input.value.trim();
    if (msg !== "") {
        socket.emit("chat message", {
            user: "<?= isset($_SESSION['tk']) ? addslashes($r['tenkh']) : 'Khách' ?>",
            message: msg
        });
        input.value = "";
    }
}

function toggleChatbox() {
    const popup = document.getElementById("chatbox-popup");
    popup.style.display = (popup.style.display === "none") ? "block" : "none";
}
*/

const socket = io("http://localhost:3000");

let unreadCount = 0;

function detectChatElements() {
    if (currentUserRole === 1) {
        return {
            popup: document.getElementById("admin-chatbox-popup"),
            toggle: document.getElementById("admin-chat-toggle"),
            input: document.getElementById("admin-chat-input"),
            messages: document.getElementById("admin-chat-messages"),
            badge: document.getElementById("admin-unread-count"),
        };
    } else {
        return {
            popup: document.getElementById("chatbox-popup"),
            toggle: document.getElementById("chat-toggle"),
            input: document.getElementById("chat-input"),
            messages: document.getElementById("chat-messages"),
            badge: null,
        };
    }
}

const chatUI = detectChatElements();

socket.emit("register", { userId: currentUserId });

// Gửi tin nhắn
function sendMessage() {
    const msg = chatUI.input.value.trim();
    if (msg !== "") {
        socket.emit("chat message", {
            from: currentUserId,
            to: targetId,
            user: currentUserName,
            message: msg
        });
        chatUI.input.value = "";
    }
}

// Nhận tin nhắn
socket.on("chat message", function(data) {
    const div = document.createElement("div");
    div.innerHTML = `<strong style="color:${data.from == currentUserId ? '#007bff' : '#e74c3c'}">${data.user}:</strong> ${data.message}`;
    chatUI.messages.appendChild(div);
    chatUI.messages.scrollTop = chatUI.messages.scrollHeight;

    if (chatUI.popup.style.display === "none" && chatUI.badge) {
        unreadCount++;
        chatUI.badge.textContent = unreadCount;
        chatUI.badge.style.display = "inline-block";
    }
});

// Toggle chatbox
function toggleChatbox() {
    chatUI.popup.style.display = (chatUI.popup.style.display === "none") ? "block" : "none";

    if (chatUI.popup.style.display === "block" && chatUI.badge) {
        unreadCount = 0;
        chatUI.badge.style.display = "none";
    }
}

// Gán toggle cho nút nổi
// chatUI.toggle.onclick = toggleChatbox;
window.onload = function() {
    chatUI.toggle.onclick = toggleChatbox;
};


// Load lịch sử chat
async function loadMessages() {
    const res = await fetch(`api/load_messages.php?me=${currentUserId}&target=${targetId}`);
    const messages = await res.json();

    chatUI.messages.innerHTML = "";
    messages.forEach(msg => {
        const div = document.createElement("div");
        div.innerHTML = `<strong style="color:${msg.from_id == currentUserId ? '#007bff' : '#e74c3c'}">${msg.from_id == currentUserId ? "Bạn" : "Đối phương"}:</strong> ${msg.message}`;
        chatUI.messages.appendChild(div);
    });
    chatUI.messages.scrollTop = chatUI.messages.scrollHeight;
}

// Tải lịch sử khi mở popup
chatUI.toggle.addEventListener("click", () => {
    if (chatUI.popup.style.display === "none") {
        loadMessages();
    }
});