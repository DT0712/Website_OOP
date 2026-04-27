// ===== CONFIG =====
const API_URL = "http://localhost/Website_OOP/chat-service/public/chat/send";

// ===== INIT =====
document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("chat-input");

    // gửi bằng Enter
    input.addEventListener("keypress", function(e){
        if(e.key === "Enter"){
            e.preventDefault();
            sendMessage();
        }
    });
});

// ===== SEND MESSAGE =====
async function sendMessage() {
    const input = document.getElementById("chat-input");
    const message = input.value.trim();

    if(message === "") return;

    addMessage(message, "user");
    input.value = "";

    // loading tạm
    const loadingId = addMessage("Đang trả lời...", "ai", true);

    try {
        const response = await fetch(API_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                message: message,
                session_id: getSessionId()
            })
        });

        // ❌ lỗi HTTP
        if(!response.ok){
            throw new Error("HTTP error: " + response.status);
        }

        const data = await response.json();

        // xoá loading
        removeMessage(loadingId);

        // ❌ API không trả đúng format
        if(!data || !data.reply){
            addMessage("AI service error!", "ai");
            return;
        }

        addMessage(data.reply, "ai");

    } catch (error) {
        console.error("CHAT ERROR:", error);

        removeMessage(loadingId);
        addMessage("Không kết nối được Chat Service ❌", "ai");
    }
}

// ===== ADD MESSAGE =====
function addMessage(text, sender, isTemp = false){
    const box = document.getElementById("chat-messages");

    const div = document.createElement("div");
    div.className = sender === "user" ? "msg-user" : "msg-ai";
    div.innerText = text;

    // dùng để xoá loading
    if(isTemp){
        const id = "msg_" + Date.now();
        div.id = id;
        box.appendChild(div);
        box.scrollTop = box.scrollHeight;
        return id;
    }

    box.appendChild(div);
    box.scrollTop = box.scrollHeight;
}

// ===== REMOVE TEMP MESSAGE =====
function removeMessage(id){
    const el = document.getElementById(id);
    if(el) el.remove();
}

// ===== SESSION =====
function getSessionId(){
    let session = localStorage.getItem("chat_session");

    if(!session){
        session = "sess_" + Math.random().toString(36).substring(2, 10);
        localStorage.setItem("chat_session", session);
    }

    return session;
}