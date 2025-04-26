<?php
// Kết nối DB
include("../config/connection.php"); // đúng file kết nối

$me = intval($_GET['me']);
$target = intval($_GET['target']);

$sql = "SELECT * FROM chat_messages 
        WHERE (from_id = $me AND to_id = $target) 
           OR (from_id = $target AND to_id = $me) 
        ORDER BY time ASC";

$result = mysqli_query($conn, $sql);

$messages = [];
while($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode($messages);
?>
