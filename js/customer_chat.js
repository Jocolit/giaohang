const socket = io("http://localhost:3000");



socket.emit("register", { userId: customerId });

const chatPopup = document.getElementById("chatbox-popup");
const chatToggle = document.getElementById("chat-toggle");
const chatInput = document.getElementById("chat-input");
const chatMessages = document.getElementById("chat-messages");

function sendMessage() {
    const msg = chatInput.value.trim();
    if (msg !== "") {
        socket.emit("chat message", {
            from: customerId,
            to: adminId,
            user: customerName,
            message: msg
        });
        chatInput.value = "";
    }
}

socket.on("chat message", function(data) {
    if (data.from == adminId || data.to == adminId) {
        const div = document.createElement("div");
        div.innerHTML = `<strong style="color:${data.from == customerId ? '#007bff' : '#e74c3c'}">${data.user}:</strong> ${data.message}`;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});

function toggleChatbox() {
    if (chatPopup.style.display === "none") {
        chatPopup.style.display = "block";
        loadMessages();
    } else {
        chatPopup.style.display = "none";
    }
}

chatToggle.onclick = toggleChatbox;

async function loadMessages() {
    const res = await fetch(`api/load_messages.php?me=${customerId}&target=${adminId}`);
    const messages = await res.json();

    chatMessages.innerHTML = "";
    messages.forEach(msg => {
        const div = document.createElement("div");
        div.innerHTML = `<strong style="color:${msg.from_id == customerId ? '#007bff' : '#e74c3c'}">${msg.from_id == customerId ? "Bạn" : "Admin"}:</strong> ${msg.message}`;
        chatMessages.appendChild(div);
    });
    chatMessages.scrollTop = chatMessages.scrollHeight;
}