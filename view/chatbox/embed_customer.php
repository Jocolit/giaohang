
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
.message {
  padding: 8px 12px;
  border-radius: 15px;
  max-width: 75%;
  margin: 5px 0;
  display: inline-block;
  clear: both;
  word-break: break-word;
  font-size: 14px;
}

.message.sent {
  background-color: #007bff;
  color: white;
  float: right;
  text-align: right;
}

.message.received {
  background-color: #f1f1f1;
  color: black;
  float: left;
  text-align: left;
}
</style>

</head>
<?php
include_once("control/c_dangnhap.php");
$p = new C_dangnhap();
$con = $p->get_lay1kh($_SESSION["tk"]);
if ($con) {
    $r = $con->fetch_assoc();
    $userName = addslashes($r['tenkh']);
    $customerId = $r['makh'];
} else {
    $userName = "Khách";
    $customerId = 0;
}
?>
<body>
    
<div id="chatbox-popup" style="display:none; position:fixed; bottom:90px; right:20px; width:320px; background:#fff; border-radius:15px; box-shadow:0 10px 30px rgba(0,0,0,0.1); overflow:hidden; z-index:999;">
    <div style="background:linear-gradient(to right,#007bff,#00c6ff);color:white;padding:12px 15px;font-weight:bold;">
        💬 Hỗ trợ trực tuyến
    </div>
    <div id="chat-messages" style="height:220px; overflow-y:auto; padding:12px; background:#f9f9f9; font-size:14px;"></div>
    <div style="padding:10px; display:flex; gap:5px; background:#fff;">
        <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." style="flex:1; border:1px solid #ddd; border-radius:8px; padding:8px; font-size:14px;">
        <button onclick="sendMessage()" style="background:#007bff; color:white; border:none; padding:8px 14px; border-radius:8px; font-size:14px;">Gửi</button>
    </div>
</div>

<div id="chat-toggle" onclick="toggleChatbox()" style="position:relative; ...">
    
    <span id="customer-badge" style="display:none; position:absolute; top:-4px; right:-4px; background:red; color:white; font-size:10px; padding:2px 6px; border-radius:50%;">!</span>
</div>

</body>
</html>



<script>
const currentCustomerId = <?= $customerId ?>;
const currentUserName = "<?= $userName ?>";
</script>

<script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
<script src="js/customer_chat.js"></script>
