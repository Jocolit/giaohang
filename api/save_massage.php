<?php
include("../config/connection.php");

$data = json_decode(file_get_contents("php://input"), true);

$from = intval($data['from']);
$to = intval($data['to']);
$message = mysqli_real_escape_string($conn, $data['message']);
$time = date("Y-m-d H:i:s");

$sql = "INSERT INTO chat_messages (from_id, to_id, message, time)
        VALUES ($from, $to, '$message', '$time')";

if(mysqli_query($conn, $sql)){
    echo json_encode(["status" => "success"]);
}else{
    echo json_encode(["status" => "fail", "error" => mysqli_error($conn)]);
}
?>
