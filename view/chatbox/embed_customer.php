
<!-- Chatbox Popup -->
<div id="chatbox-popup" style="display:none; position: fixed; bottom: 90px; right: 20px; width: 320px; background: #fff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; z-index: 999;">
    <div style="background: linear-gradient(to right, #007bff, #00c6ff); color: white; padding: 12px 15px; font-weight: bold;">
        💬 Hỗ trợ trực tuyến
    </div>
    <div id="chat-messages" style="height: 220px; overflow-y: auto; padding: 12px; background: #f9f9f9; font-size: 14px;"></div>
    <div style="padding: 10px; display: flex; gap: 5px; background: #fff;">
        <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." 
            style="flex: 1; border: 1px solid #ddd; border-radius: 8px; padding: 8px; font-size: 14px;">
        <button onclick="sendMessage()" 
            style="background: #007bff; color: white; border: none; padding: 8px 14px; border-radius: 8px; font-size: 14px; cursor: pointer;">
            Gửi
        </button>
    </div>
</div>

<!-- Nút tròn -->
<div id="chat-toggle" onclick="toggleChatbox()" 
    style="position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; background: #007bff; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 1000;">
    Tư vấn
</div>

<!-- Socket.IO -->
<script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
<script src="js/customer_chat.js"></script>
