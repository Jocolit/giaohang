<?php
$servername = "localhost";
$username = "root";       // hoặc tên user MySQL của bạn
$password = "";           // mật khẩu nếu có
$dbname = "giaohang";     // đúng tên database của bạn

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
?>
