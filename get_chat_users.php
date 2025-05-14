<?php
$conn = new mysqli("localhost", "root", "", "giaohang");
$conn->set_charset("utf8");

// Lấy danh sách khách hàng đã nhắn tin
$sql = "SELECT room, MAX(user) as user FROM chat_messages WHERE USER not LIKE 'Quản lý' GROUP BY room";

$result = $conn->query($sql);
$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = [
        "room" => $row["room"],
        "user" => $row["user"]
    ];
}

header('Content-Type: application/json');
echo json_encode($users);
?>
