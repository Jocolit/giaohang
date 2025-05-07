// const express = require('express');
// const http = require('http');
// const { Server } = require('socket.io');
// const mysql = require('mysql2');

// const app = express();
// const server = http.createServer(app);
// const io = new Server(server, { cors: { origin: "*" } });

const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Server } = require('socket.io');
const io = new Server(server, { cors: { origin: "*" } });
const mysql = require('mysql2');

app.use(express.json()); // <== Thêm dòng này

// Kết nối database
const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "giaohang"
});

db.connect((err) => {
    if (err) {
        console.error("Database connection error:", err);
    } else {
        console.log("Database connected successfully!");
    }
});

// Route API nhận thông báo từ PHP
app.post('/payment-success', (req, res) => {
    const { orderId } = req.body;
    console.log('PHP gửi tới: orderId', orderId);

    io.emit('payment update', { orderId, status: 'Đã thanh toán' });
    res.json({ success: true });
});

io.on('connection', (socket) => {
    console.log('Client connected');

    // Join đúng room khách hàng
    socket.on('join room', (data) => {
        const { room } = data;
        const roomIdString = String(room); // **Sửa đổi:** Chuyển đổi thành chuỗi
        socket.join(roomIdString);
        console.log(`Socket joined room: ${roomIdString}`);

        db.query("SELECT user, message FROM chat_messages WHERE room = ? ORDER BY created_at ASC", [roomIdString], (err, results) => {
            if (!err) {
                socket.emit('history', results);
            }
        });
    });

    socket.on('chat message', (data) => {
        const { room, user, message } = data;
        const roomIdString = String(room); // **Sửa đổi:** Chuyển đổi thành chuỗi

        db.query("INSERT INTO chat_messages (room, user, message) VALUES (?, ?, ?)", [roomIdString, user, message]);

        console.log("Server phát tin nhắn:", { room: roomIdString, user, message });
        io.to(roomIdString).emit('chat message', { room: roomIdString, user, message }); // **Sửa đổi:** Phát với room là chuỗi
    });

    // ----- Thêm phần QR giả lập thanh toán -----
    socket.on('payment success', (data) => {
        console.log('Nhận được tín hiệu payment success:', data);
        const { orderId } = data;
        if (!orderId) {
            console.error('Thiếu orderId!');
            return;
        }

        db.query("UPDATE donhang SET thanhtoan = 'Đã thanh toán' WHERE madh = ?", [orderId], (err, result) => {
            if (err) {
                console.error('Lỗi update database:', err);
            } else {
                console.log(`Update thành công đơn hàng ${orderId}`);
            }
        });

        io.emit('payment update', { orderId: orderId, status: 'Đã thanh toán' });
    });



    socket.on('disconnect', () => {
        console.log('Client disconnected');
    });
});

server.listen(3000, () => {
    console.log('Server running on http://localhost:3000');
});