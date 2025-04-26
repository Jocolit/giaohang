/*
const express = require("express");
const http = require("http");
const { Server } = require("socket.io");

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
    cors: {
        origin: "*"
    }
});

io.on("connection", (socket) => {
    console.log("Client connected");

    // socket.on("chat message", (data) => {
    //     io.emit("chat message", data); // broadcast tin nhắn
    // });
    const axios = require("axios"); // ⚠️ đảm bảo đã npm install axios

    socket.on("chat message", (data) => {
        io.emit("chat message", data); // broadcast

        // lưu về PHP API
        axios.post("http://localhost:8088/giaohang/api/save_message.php", {
            from: data.from,
            to: data.to,
            message: data.message,
            time: new Date().toISOString()
        });
    });


    socket.on("disconnect", () => {
        console.log("Client disconnected");
    });
});

server.listen(3000, () => {
    console.log("Socket.IO server running at http://localhost:3000/");
});
*/
// tạo trước 3 file chat.js, server.js, embed.php(giao diện)
// tải node js trước
// lệnh kiểm tra terminal node -v
// Trước tiên vào thư mục hiện hành, lệnh cài đặt socket: npm install express socket.io   
// lệnh chạy: node server.js (tên file)
// tên lưu trữ trên chat gpt: realtime_chat

// install axios:  Axios là thư viện giúp client tương tác với server thông qua giao thức HTTP dựa trên các Promises

const express = require("express");
const http = require("http");
const { Server } = require("socket.io");
const axios = require("axios"); // để lưu tin nhắn vào PHP

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
    cors: {
        origin: "*"
    }
});

// Mapping userId -> socketId
let users = {};

io.on("connection", (socket) => {
    console.log("🟢 Client connected:", socket.id);

    socket.on("register", (data) => {
        users[data.userId] = socket.id;
        console.log("Registered user:", data.userId);
    });

    socket.on("chat message", (data) => {
        console.log(`💬 ${data.user}: ${data.message}`);

        // Emit realtime cho người nhận nếu đang online
        if (users[data.to]) {
            io.to(users[data.to]).emit("chat message", data);
        } else {
            // Nếu người nhận chưa online → vẫn emit broadcast để lưu tin
            io.emit("chat message", data);
        }

        // Gửi tin nhắn POST về PHP API để lưu vào DB
        axios.post("http://localhost:8088/giaohang/api/save_message.php", {
            from: data.from,
            to: data.to,
            message: data.message
        }).then(response => {
            console.log("✅ Tin nhắn đã lưu");
        }).catch(error => {
            console.error("❌ Lỗi lưu tin nhắn:", error.message);
        });
    });

    socket.on("disconnect", () => {
        console.log("🔴 Client disconnected:", socket.id);
        // Xóa userId khỏi danh sách
        for (const [uid, sid] of Object.entries(users)) {
            if (sid === socket.id) {
                delete users[uid];
                break;
            }
        }
    });
});

server.listen(3000, () => {
    console.log("🚀 Socket.IO server running at http://localhost:3000/");
});