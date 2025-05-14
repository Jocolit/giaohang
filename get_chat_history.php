<?php
$room = $_GET['room'];
$conn = new mysqli("localhost", "root", "", "giaohang");
$conn->set_charset("utf8");

$stmt = $conn->prepare("SELECT user, message, created_at FROM chat_messages WHERE room = ? ORDER BY created_at ASC");
$stmt->bind_param("s", $room);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
