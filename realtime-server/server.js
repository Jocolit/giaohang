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

// Tạm lưu map userId ↔ socketId
const userSockets = {};

io.on("connection", (socket) => {
    console.log("Client connected:", socket.id);

    // Bước 1: client gửi tên (userId) khi kết nối
    socket.on("register", (data) => {
        const userId = data.userId;
        userSockets[userId] = socket.id;

        const room = "room_" + userId;
        socket.join(room); // vào phòng riêng
        console.log(`User ${userId} joined ${room}`);
    });

    // Nhận và chuyển tin nhắn theo room
    socket.on("chat message", (data) => {
        const room = data.toRoom; // toRoom: "room_123"
        io.to(room).emit("chat message", {
            user: data.user,
            message: data.message
        });
    });

    socket.on("disconnect", () => {
        console.log("Client disconnected");
    });
});