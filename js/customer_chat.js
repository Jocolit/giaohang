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