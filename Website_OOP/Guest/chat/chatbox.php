<!-- FLOAT BUTTON -->
<div id="chat-bubble">💬</div>
<!-- CHAT WIDGET -->
<div id="chat-widget">

    <div id="chat-header">
        🤖 AI Bike Support
        <span id="chat-close">✖</span>
    </div>

    <div id="chat-messages">
        <div class="msg-ai">Xin chào 👋 Tôi có thể tư vấn xe đạp cho bạn!</div>
    </div>

    <div id="chat-input-box">
        <input id="chat-input" placeholder="Nhập tin nhắn..." />
        <button onclick="sendMessage()">Gửi</button>
    </div>

</div>

<script>
const bubble = document.getElementById("chat-bubble");
const widget = document.getElementById("chat-widget");
const closeBtn = document.getElementById("chat-close");

bubble.addEventListener("click", () => {
    widget.style.display = "flex";
});

closeBtn.addEventListener("click", () => {
    widget.style.display = "none";
});
</script>
<script src="/Website_OOP/Website_OOP/guest/chat/chat.js"></script>