const socket = io("http://localhost:3000");



socket.emit("register", { userId: adminId });

const chatPopup = document.getElementById("admin-chatbox-popup");
const chatToggle = document.getElementById("admin-chat-toggle");
const chatInput = document.getElementById("admin-chat-input");
const chatMessages = document.getElementById("admin-chat-messages");
const unreadBadge = document.getElementById("admin-unread-count");

let unreadCount = 0;
let currentCustomerId = null;

function sendMessage() {
    const msg = chatInput.value.trim();
    if (msg !== "" && currentCustomerId) {
        socket.emit("chat message", {
            from: adminId,
            to: currentCustomerId,
            user: adminName,
            message: msg
        });
        chatInput.value = "";
    }
}

socket.on("chat message", function(data) {
    if (data.to == adminId || data.from == adminId) {
        if (!currentCustomerId) {
            currentCustomerId = data.from;
        }

        const div = document.createElement("div");
        div.innerHTML = `<strong style="color:${data.from == adminId ? '#e74c3c' : '#007bff'}">${data.user}:</strong> ${data.message}`;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;

        if (chatPopup.style.display === "none") {
            unreadCount++;
            unreadBadge.textContent = unreadCount;
            unreadBadge.style.display = "inline-block";
        }
    }
});

function toggleAdminChatbox() {
    if (chatPopup.style.display === "none") {
        chatPopup.style.display = "block";
        if (currentCustomerId) {
            loadMessages();
        }
        unreadCount = 0;
        unreadBadge.style.display = "none";
    } else {
        chatPopup.style.display = "none";
    }
}

chatToggle.onclick = toggleAdminChatbox;

async function loadMessages() {
    const res = await fetch(`api/load_messages.php?me=${adminId}&target=${currentCustomerId}`);
    const messages = await res.json();

    chatMessages.innerHTML = "";
    messages.forEach(msg => {
        const div = document.createElement("div");
        div.innerHTML = `<strong style="color:${msg.from_id == adminId ? '#e74c3c' : '#007bff'}">${msg.from_id == adminId ? "Bạn" : "Khách"}:</strong> ${msg.message}`;
        chatMessages.appendChild(div);
    });
    chatMessages.scrollTop = chatMessages.scrollHeight;
}