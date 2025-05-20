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
  background-color: #e74c3c;
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
<body>
<div id="admin-chatbox-full" style="display:none; position:fixed; top:0; right:0; width:400px; height:100%; background:#fff; border-left:1px solid #ddd; z-index:9999; box-shadow:-2px 0 8px rgba(0,0,0,0.1); font-family:'Segoe UI',sans-serif;">
    <div style="background:#e74c3c; color:white; padding:12px 16px; font-size:17px; font-weight:600; display:flex; justify-content:space-between; align-items:center;">
        💬 Chat khách hàng
        <button onclick="closeAdminChatbox()" style="background:none; border:none; color:white; font-size:20px; cursor:pointer;">×</button>
    </div>
    <div style="padding:10px; border-bottom:1px solid #ddd;">
    <input type="text" id="search-user" placeholder="🔍 Tìm theo tên khách hàng" style="width:100%; padding:8px 10px; border-radius:6px; border:1px solid #ccc; font-size:14px;">

        <div style="margin-top:8px; font-size:13px; color:#555;">
            <select style="width:100%; padding:6px 8px; border-radius:5px; border:1px solid #ccc;">
                <option>Tất cả</option>
                <option>Chưa đọc</option>
                <option>Chưa phản hồi</option>
                <option>Đã ghim</option>
            </select>
        </div>
    </div>
    <div id="chat-conversation-list" style="height:calc(100% - 140px); overflow-y:auto; padding:10px;"></div>
    <div id="no-conversation" style="padding:20px; text-align:center; color:#aaa; font-style:italic;">Không có cuộc hội thoại nào.</div>
</div>

<div id="chat-detail-popup" style="display:none; position:fixed; bottom:0; right:0; transform: translateX(0); width:400px; height:50%; background:white; box-shadow:-2px 0 8px rgba(0,0,0,0.1); z-index:10001; border-left:1px solid #ddd; border-radius:0;">
    <div style="background:#e74c3c; color:white; padding:12px; font-size:16px; font-weight:bold; display:flex; justify-content:space-between; align-items:center;">
        Đoạn hội thoại
        <button onclick="closeChatDetail()" style="background:none; border:none; color:white; font-size:18px;">×</button>
    </div>
    <div id="chat-detail-messages" style="height:calc(100% - 120px); overflow-y:auto; padding:10px; font-size:14px;"></div>
    <div style="position:fixed; bottom:0; left:0; width:400px; background:#fff; padding:12px 16px; display:flex; border-top:1px solid #ddd;">
        <input type="text" id="admin-chat-input" placeholder="Nhập tin nhắn..." style="flex:1; padding:8px 10px; border-radius:6px; border:1px solid #ccc; font-size:14px;">
        <button onclick="sendAdminMessage()" style="margin-left:6px; padding:8px 14px; background:#e74c3c; color:white; border:none; border-radius:6px;">Gửi</button>
    </div>
</div>

</body>
</html>
<script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
<script src="js/admin_chat.js"></script>
