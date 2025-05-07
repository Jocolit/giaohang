
<?php
    session_start();

    if(isset($_REQUEST["dangnhap"]))
        include_once("view/dangnhap/index.php");
    else{

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ Thống Quản Lý Giao Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fa;
            font-family: Arial, sans-serif;
        }
        .hero {
            background-color: #007bff;
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        .section {
            padding: 40px 0;
        }
        .card {
            border-radius: 16px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>

    <div class="hero">
        <h1>Chào mừng đến với Hệ Thống Giao Hàng</h1>
        <p>Quản lý đơn hàng, nhân viên giao hàng, kho và COD nhanh chóng, hiệu quả</p>
    </div>

    <div class="container section">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="card p-3">
                    <h4>Khách Hàng</h4>
                    <p>Đặt hàng, theo dõi đơn, hủy đơn và xem lịch sử giao hàng</p>
                    <?php
                        if(!isset($_SESSION["dn"])){
                            echo '<a href="index.php?dangnhap" class="btn btn-primary">Đăng Nhập</a>';
                        }else{
                            echo '<a href="index.php?dangxuat" class="btn btn-primary">Đăng xuất</a>';
                        }
                    ?>
                    
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card p-3">
                    <h4>Nhân Viên Giao Hàng</h4>
                    <p>Xem danh sách đơn được phân công và cập nhật trạng thái giao</p>
                    <a href="index.php?dangnhap" class="btn btn-primary">Đăng Nhập</a>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card p-3">
                    <h4>Nhân Viên Kho</h4>
                    <p>Quản lý hàng tồn, tạo phiếu nhập xuất kho</p>
                    <a href="index.php?dangnhap" class="btn btn-primary">Đăng Nhập</a>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card p-3">
                    <h4>Quản Lý / Điều Phối</h4>
                    <p>Xem báo cáo, phân công nhân viên và kiểm soát COD</p>
                    <a href="index.php?dangnhap" class="btn btn-primary">Đăng Nhập</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 bg-light">
        <p>&copy; 2025 Hệ Thống Quản Lý Giao Hàng. All rights reserved.</p>
    </footer>
<?php
    if(isset($_REQUEST["dangxuat"]))
        include_once("view/dangxuat/index.php");
?>
</body>
</html>
<?php
    }
?>

<div class="card-container">
        <div class="card">
            <h3>Tổng số đơn hàng trong ngày</h3>
            <p>98 đơn</p>
        </div>
        <div class="card">
            <h3>Số lượng nhân viên hoạt động</h3>
            <p>30 nugười</p>
        </div>
        <div class="card">
            <h3>Tổng đơn hàng trong kho</h3>
            <p>12 người</p>
        </div>
        <div class="card">
            <h3>Doanh thu trong ngày</h3>
            <p>500000k</p>
        </div>
    </div>

    <?php
session_start();
// if (!isset($_SESSION["dn"])) {
//     echo " <script>window.location.href='index.php'</script> ";
// }
include_once("control/c_dangnhap.php");
$p = new C_dangnhap();
$con = $p->get_lay1kh($_SESSION["tk"]);
if($con){
$r = $con->fetch_assoc();
}else{
    echo 'Có lỗi';
    
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Khách Hàng - Quản lý giao hàng</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f2f6fc;
            margin: 0;
        }

        header {
            background: #3498db;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav {
            background: #2980b9;
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 10px 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            padding: 30px;
            max-width: 800px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .card h3 {
            margin-top: 0;
            color: #333;
        }

        footer {
            background: #ecf0f1;
            text-align: center;
            padding: 15px;
            color: #777;
            font-size: 14px;
        }

        .btn {
            background: #3498db;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn:hover {
            background: #2c80b4;
        }
    </style>
</head>
<body>

<header>
    <h2>Chào mừng, <?= $r["tenkh"] ?> 👋</h2>
</header>

<nav>
    <a href="#">📦 Tạo đơn hàng</a>
    <a href="#">🔍 Tra cứu đơn hàng</a>
    <a href="#">📜 Lịch sử mua hàng</a>
    <a href="#">👤 Tài khoản</a>
    <a href="customer_home.php?dangxuat">🚪 Đăng xuất</a>
</nav>

<div class="container">

    <div class="card">
        <h3>Thông báo</h3>
        <p>Bạn có <strong>2</strong> đơn hàng đang chờ giao. Theo dõi trạng thái tại mục <strong>Tra cứu đơn hàng</strong>.</p>
    </div>

    <div class="card">
        <h3>Gợi ý</h3>
        <p>Bạn có thể dễ dàng tạo đơn hàng mới hoặc xem lại lịch sử các đơn trước.</p>
        <button class="btn">Tạo đơn ngay</button>
    </div>

</div>
<?php
    if(isset($_REQUEST["dangxuat"]))
        include_once("view/dangxuat/index.php");
?>
<footer>
    © 2025 Ứng dụng Giao Hàng | Bảo mật thông tin tuyệt đối
</footer>

</body>
</html>

1. file admin_chat.js

// const adminSocket = io("http://localhost:3000");
// let unreadCount = 0;

// adminSocket.on("chat message", function(data) {
//     // Hiển thị popup nếu đang mở
//     const box = document.getElementById("admin-chat-messages");
//     const div = document.createElement("div");
//     div.innerHTML = `<strong style="color:#e74c3c">${data.user}:</strong> ${data.message}`;
//     box.appendChild(div);
//     box.scrollTop = box.scrollHeight;

//     // Nếu popup đang ẩn → tăng số thông báo
//     const popup = document.getElementById("admin-chatbox-popup");
//     if (popup.style.display === "none") {
//         unreadCount++;
//         const badge = document.getElementById("admin-unread-count");
//         badge.textContent = unreadCount;
//         badge.style.display = "inline-block";
//     }
// });

// function toggleAdminChatbox() {
//     const popup = document.getElementById("admin-chatbox-popup");
//     popup.style.display = (popup.style.display === "none") ? "block" : "none";

//     // Nếu vừa mở → reset badge
//     if (popup.style.display === "block") {
//         unreadCount = 0;
//         document.getElementById("admin-unread-count").style.display = "none";
//     }
// }

// function sendAdminMessage() {
//     const input = document.getElementById("admin-chat-input");
//     const msg = input.value.trim();
//     if (msg !== "") {
//         adminSocket.emit("chat message", {
//             user: "Admin",
//             message: msg
//         });
//         input.value = "";
//     }
// }

const adminSocket = io("http://localhost:3000");

const customerId = currentCustomerId; // admin cũng cần biết đang chat với khách nào
adminSocket.emit("join room", { customerId });
adminSocket.emit("load history", { customerId });

let unreadCount = 0;

adminSocket.on("chat message", function(data) {
    const box = document.getElementById("admin-chat-messages");
    const div = document.createElement("div");
    div.innerHTML = `<strong style="color:#e74c3c">${data.user}:</strong> ${data.message}`;
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;

    // Nếu popup đang ẩn, hiện badge
    const popup = document.getElementById("admin-chatbox-popup");
    if (popup.style.display === "none") {
        unreadCount++;
        const badge = document.getElementById("admin-unread-count");
        badge.textContent = unreadCount;
        badge.style.display = "inline-block";
    }
});

adminSocket.on("history", function(messages) {
    const box = document.getElementById("admin-chat-messages"); // id cho ô tin nhắn admin
    box.innerHTML = "";

    messages.forEach(msg => {
        const div = document.createElement("div");
        div.innerHTML = `<strong>${msg.user}:</strong> ${msg.message}`;
        box.appendChild(div);
    });

    box.scrollTop = box.scrollHeight;
});

function toggleAdminChatbox() {
    const popup = document.getElementById("admin-chatbox-popup");
    popup.style.display = (popup.style.display === "none") ? "block" : "none";

    // Mở popup thì reset badge
    if (popup.style.display === "block") {
        unreadCount = 0;
        document.getElementById("admin-unread-count").style.display = "none";
    }
}

// function sendAdminMessage() {
//     const input = document.getElementById("admin-chat-input");
//     const msg = input.value.trim();
//     if (msg !== "") {
//         adminSocket.emit("chat message", {
//             user: currentUserName,
//             message: msg
//         });
//         input.value = "";
//     }
// }

function sendAdminMessage() {
    const input = document.getElementById("admin-chat-input");
    const msg = input.value.trim();
    if (msg !== "") {
        adminSocket.emit("chat message", {
            customerId: customerId, // cũng gửi kèm ID phòng
            user: currentUserName, // "Admin" hoặc tên quản trị viên
            message: msg
        });
        input.value = "";
    }
}


2. File server.js

// const express = require("express");
// const http = require("http");
// const { Server } = require("socket.io");

// const app = express();
// const server = http.createServer(app);
// const io = new Server(server, {
//     cors: {
//         origin: "*"
//     }
// });

// io.on("connection", (socket) => {
//     console.log("Client connected");

//     socket.on("chat message", (data) => {
//         io.emit("chat message", data); // broadcast tin nhắn
//     });

//     socket.on("disconnect", () => {
//         console.log("Client disconnected");
//     });
// });

// server.listen(3000, () => {
//     console.log("Socket.IO server running at http://localhost:3000/");
// });

// mới

const express = require("express");
const http = require("http");
const { Server } = require("socket.io");
const mysql = require("mysql2"); // đúng thư viện mysql2

const app = express();
const server = http.createServer(app);
const io = new Server(server, { cors: { origin: "*" } });

const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "", // thay nếu cần
    database: "giaohang"
});

// Kết nối DB
db.connect((err) => {
    if (err) {
        console.error("Kết nối database thất bại:", err);
    } else {
        console.log("Kết nối database thành công");
    }
});

io.on("connection", (socket) => {
    console.log("Client connected");

    socket.on("join room", (data) => {
        const room = "room_" + data.customerId;
        socket.join(room);
        socket.room = room;
        console.log(`Joined room ${room}`);
    });

    socket.on("chat message", (data) => {
        console.log("Nhận tin nhắn từ client:", data);

        const room = socket.room;
        if (!room) {
            console.error("Chưa join room, bỏ tin nhắn");
            return;
        }

        db.query(
            "INSERT INTO chat_messages (room, user, message) VALUES (?, ?, ?)", [room, data.user, data.message],
            (err, result) => {
                if (err) console.error("Lỗi lưu chat:", err);
            }
        );

        io.to(room).emit("chat message", {
            user: data.user,
            message: data.message
        });
    });

    socket.on("load history", (data) => {
        const room = "room_" + data.customerId;
        db.query(
            "SELECT user, message FROM chat_messages WHERE room = ? ORDER BY created_at ASC", [room],
            (err, results) => {
                if (err) {
                    console.error("Lỗi lấy lịch sử:", err);
                } else {
                    socket.emit("history", results);
                }
            }
        );
    });

    socket.on("disconnect", () => {
        console.log("Client disconnected");
    });
});

server.listen(3000, () => {
    console.log("Server running on http://localhost:3000/");
});

3. dashboard Admin

<?php
session_start();

// Kiểm tra đăng nhập (demo thôi, bạn có thể thay bằng kiểm tra thực tế)

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý - Hệ thống giao hàng</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            height: 100vh;
            background: #f4f6f9;
        }

        .sidebar {
            width: 240px;
            background: #34495e;
            color: #ecf0f1;
            padding: 20px;
            position: fixed;
            height: 100%;
        }

        .sidebar h2 {
            margin-bottom: 30px;
            text-align: center;
        }

        .sidebar a {
            display: block;
            padding: 12px 10px;
            margin-bottom: 10px;
            color: #ecf0f1;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background: #2c3e50;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            color: #2c3e50;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .main {
            flex-grow: 1;
            padding: 30px;
            margin-left: 240px;
        }

        .header {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin-bottom: 10px;
            font-size: 20px;
            color: #2c3e50;
        }

        .card p {
            font-size: 18px;
            font-weight: bold;
            color: #2980b9;
        }

        .section {
            margin-top: 40px;
        }

        .section h4 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #2c3e50;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background: #ecf0f1;
            font-weight: bold;
        }

        .button {
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #2980b9;
        }

        .logout {
            margin-top: 40px;
            text-align: center;
        }

        .logout a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }

        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<?php
    include_once("control/c_dangnhap.php");
    $p = new C_dangnhap();

    $con = $p->get_nhanvien();
    $conn = $p->get_nhanvien($_SESSION["tk"]);
    if($conn)
        $rr = $conn->fetch_assoc();
    else
        echo 'Có lỗi';
?>

<body>

<div class="sidebar">
    <h2><a href="dashboard_admin.php"><?= $rr["tennv"]; ?></a></h2>
    <a href="#">📦 Quản lý đơn hàng</a>
    <div class="dropdown">
        <a href="dashboard_admin.php?qlnv">🚚 Quản lý nhân viên</a>
        <div class="dropdown-content">
            <a href="dashboard_admin.php?them">Thêm nhân viên</a>
            <a href="dashboard_admin.php?xoa">Xóa nhân viên</a>
            <a href="dashboard_admin.php?sua">Cập nhật thông tin nhân viên</a>
        </div>
    </div>
    <a href="#">🏬 Quản lý kho</a>
    <a href="#">💰 Quản lý COD</a>
    <a href="#">📊 Báo cáo thống kê</a>
    <div class="logout">
        <a href="dashboard_admin.php?dangxuat">Đăng xuất</a>
    </div>
</div>

<div class="main">
    <div class="header">Trang quản trị hệ thống</div>

    <div class="card-container">
        <div class="card">
            <h3>Tổng số đơn hàng trong ngày</h3>
            <p>98 đơn</p>
        </div>
        <div class="card">
            <h3>Số lượng nhân viên hoạt động</h3>
            <p>30 nugười</p>
        </div>
        <div class="card">
            <h3>Tổng đơn hàng trong kho</h3>
            <p>12 người</p>
        </div>
        <div class="card">
            <h3>Doanh thu trong ngày</h3>
            <p>500000k</p>
        </div>
    </div>

    <?php
        if(isset($_REQUEST["qlnv"]))
            include_once("view/quanlynv/index.php");
        elseif(isset($_REQUEST["them"]))
            include_once("view/themnv/index.php");
    ?>

</div>

<?php
    if(isset($_REQUEST["dangxuat"]))
        include_once("view/dangxuat/index.php");
?>
<?php include_once("view/chatbox/embed_admin.php"); ?>
</body>
</html>


<script>

const adminSocket = io("http://localhost:3000");

let currentCustomerId = null; // Biến để lưu ID khách hàng hiện tại
let currentUserName = "Admin"; // Tên của admin

let unreadCount = 0; // Biến để đếm số tin nhắn chưa đọc

// Mở cửa sổ chatbox của admin và tải danh sách khách hàng đã từng nhắn tin
function openAdminChatbox() {
    document.getElementById("admin-chatbox-full").style.display = "block";

    // Gọi API lấy danh sách khách hàng đã từng nhắn tin
    fetch("get_chat_users.php")
        .then(response => response.json())
        .then(users => {
            const list = document.getElementById("chat-conversation-list");
            list.innerHTML = ""; // Xóa danh sách cũ trước khi render

            if (users.length === 0) {
                document.getElementById("no-conversation").style.display = "block"; // Nếu không có cuộc hội thoại
                return;
            }

            document.getElementById("no-conversation").style.display = "none"; // Ẩn thông báo không có hội thoại

            // Render danh sách khách hàng đã nhắn tin
            users.forEach(user => {
                const item = document.createElement("div");
                item.style.padding = "12px 16px";
                item.style.borderBottom = "1px solid #eee";
                item.style.cursor = "pointer";
                item.innerHTML = `
                    <div style="font-weight: bold;">${user.user}</div>
                    <div style="font-size: 13px; color: #555;">(${user.room})</div>
                `;

                // Khi click vào tên khách hàng, mở chat với khách đó
                item.addEventListener("click", () => {
                    openChatDetail(user.room, user.user);
                });

                list.appendChild(item); // Thêm phần tử mới vào danh sách
            });
        })
        .catch(error => {
            console.error("Error fetching users:", error); // Kiểm tra lỗi trong console
        });
}

// Đóng cửa sổ chatbox
function closeAdminChatbox() {
    document.getElementById("admin-chatbox-full").style.display = "none";
}

// Mở chi tiết cuộc hội thoại khi admin chọn khách hàng
function openChatDetail(room, username) {
    currentCustomerId = room; // Lưu ID phòng (hoặc customerId)
    document.getElementById("admin-chatbox-title").textContent = `💬 Đang trò chuyện với ${username}`;
    document.getElementById("admin-chatbox-popup").style.display = "block"; // Mở chatbox

    adminSocket.emit("join room", { customerId: currentCustomerId }); // Tham gia phòng chat
    adminSocket.emit("load history", { customerId: currentCustomerId }); // Lấy lịch sử chat
}

// Hiển thị lịch sử chat cho phòng chat đã chọn
adminSocket.on("history", function(messages) {
    const box = document.getElementById("admin-chat-messages");
    box.innerHTML = ""; // Xóa tin nhắn cũ

    // Render từng tin nhắn trong lịch sử
    messages.forEach(msg => {
        const div = document.createElement("div");
        div.innerHTML = `<strong>${msg.user}:</strong> ${msg.message}`;
        box.appendChild(div);
    });

    box.scrollTop = box.scrollHeight; // Cuộn xuống cuối tin nhắn
});

// Gửi tin nhắn từ admin
function sendAdminMessage() {
    const input = document.getElementById("admin-chat-input");
    const msg = input.value.trim();

    if (msg !== "" && currentCustomerId) {
        adminSocket.emit("chat message", {
            customerId: currentCustomerId, // ID của khách hàng đang trò chuyện
            user: currentUserName, // Tên của admin
            message: msg
        });

        input.value = ""; // Xóa ô nhập tin nhắn sau khi gửi
    }
}

// Lắng nghe tin nhắn mới và hiển thị
adminSocket.on("chat message", function(data) {
    const box = document.getElementById("admin-chat-messages");
    const div = document.createElement("div");

    div.innerHTML = `<strong style="color:#e74c3c">${data.user}:</strong> ${data.message}`;
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;

    // Nếu popup đang ẩn, hiện badge thông báo
    const popup = document.getElementById("admin-chatbox-popup");
    if (popup.style.display === "none") {
        unreadCount++;
        const badge = document.getElementById("admin-unread-count");
        badge.textContent = unreadCount;
        badge.style.display = "inline-block";
    }
});

// Khi mở popup chatbox, reset lại badge thông báo
function toggleAdminChatbox() {
    const popup = document.getElementById("admin-chatbox-popup");
    popup.style.display = (popup.style.display === "none") ? "block" : "none";

    // Reset badge khi mở popup
    if (popup.style.display === "block") {
        unreadCount = 0;
        document.getElementById("admin-unread-count").style.display = "none";
    }
}

// Mở phòng chat mới (dành cho admin)
let currentRoom = null;

function joinNewRoom(newCustomerId) {
    if (currentRoom) {
        adminSocket.emit("leave room", { customerId: currentRoom });
    }

    currentCustomerId = newCustomerId;
    currentRoom = newCustomerId;

    adminSocket.emit("join room", { customerId: currentCustomerId });
    adminSocket.emit("load history", { customerId: currentCustomerId });

    // Clear chat cũ
    const box = document.getElementById("admin-chat-messages");
    box.innerHTML = "";
}

</script>