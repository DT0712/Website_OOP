<style>
#chat-widget{
    position:fixed;
    bottom:20px;
    right:20px;
    width:300px;
    background:#fff;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.2);
    overflow:hidden;
    font-family:Arial;
}

#chat-header{
    background:#2ecc71;
    color:white;
    padding:10px;
    font-weight:bold;
}

#chat-messages{
    height:250px;
    overflow-y:auto;
    padding:10px;
    font-size:14px;
}

#chat-input{
    display:flex;
    border-top:1px solid #ddd;
}

#chat-input input{
    flex:1;
    border:none;
    padding:10px;
}

#chat-input button{
    border:none;
    background:#2ecc71;
    color:white;
    padding:10px 15px;
}
</style>

<div id="chat-widget">
    <div id="chat-header">💬 Chat hỗ trợ</div>
    <div id="chat-messages"></div>

    <div id="chat-input">
        <input id="chatText" placeholder="Nhập tin nhắn...">
        <button onclick="sendMessage()">Gửi</button>
    </div>
</div>

<script src="/website_oop/assets/js/chat.js"></script>