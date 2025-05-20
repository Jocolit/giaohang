// Import thư viện
const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const mysql = require('mysql2');

// Khởi tạo ứng dụng Express, HTTP server và Socket.IO server
const app = express();
const server = http.createServer(app);
const io = new Server(server, { cors: { origin: "*" } }); // Cho phép CORS tất cả origin

// Kết nối MySQL
const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "giaohang"
});

db.connect(err => {
    if (err) return console.error("❌ Kết nối DB lỗi:", err);
    console.log("✅ Đã kết nối database!");
});

// Middleware parse JSON
app.use(express.json());

// Sự kiện khi client kết nối tới socket
io.on('connection', socket => {
    console.log('⚡ Client kết nối');

    // Client join vào một room cụ thể
    socket.on('join room', ({ room }) => {
        const roomId = String(room); // Đảm bảo room là chuỗi
        socket.join(roomId);
        console.log(`🔗 Đã join room: ${roomId}`);

        // Gửi lại lịch sử tin nhắn cho client vừa join
        const sql = "SELECT user, message FROM chat_messages WHERE room = ? ORDER BY created_at ASC";
        db.query(sql, [roomId], (err, results) => {
            if (!err) socket.emit('history', results);
        });
    });

    // Nhận tin nhắn mới từ client
    socket.on('chat message', ({ room, user, message }) => {
        const roomId = String(room); // Đảm bảo room là chuỗi

        // Lưu tin nhắn vào DB
        const sql = "INSERT INTO chat_messages (room, user, message) VALUES (?, ?, ?)";
        db.query(sql, [roomId, user, message]);

        // Phát tin nhắn đến tất cả client trong room đó
        console.log("📨 Tin nhắn gửi:", { room: roomId, user, message });
        io.to(roomId).emit('chat message', { room: roomId, user, message });

        // Thông báo admin cập nhật danh sách người dùng
        io.emit('update user list');
    });

    // Ngắt kết nối
    socket.on('disconnect', () => {
        console.log('❎ Client ngắt kết nối');
    });
});

// Endpoint POST nhận thông báo thanh toán
app.post('/payment_update', (req, res) => {
    const { orderId } = req.body;

    if (!orderId) {
        return res.status(400).send({ message: "❗ Thiếu orderId" });
    }

    // Phát sự kiện thanh toán thành công cho toàn bộ client
    console.log(`💰 Thanh toán thành công đơn hàng: ${orderId}`);
    io.emit('payment update', { orderId });

    res.send({ message: "✅ Đã gửi sự kiện cập nhật thanh toán" });
});

// Khởi động server
server.listen(3000, () => {
    console.log('🚀 Server chạy tại http://localhost:3000');
});