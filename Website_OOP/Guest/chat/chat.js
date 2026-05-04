// ================= CONFIG =================
const API_URL = "http://localhost/Website_OOP/chat-service/public/chat/send";

console.log("Chat API:", API_URL);


// ================= INIT =================
document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("chat-input");
    if(!input) return;

    input.addEventListener("keypress", function(e){
        if(e.key === "Enter"){
            e.preventDefault();
            sendMessage();
        }
    });
});


// ================= SEND MESSAGE =================
async function sendMessage() {

    const input = document.getElementById("chat-input");
    const message = input.value.trim();
    if(message === "") return;

    addMessage(message, "user");
    input.value = "";

    const loadingId = addMessage("Đang trả lời...", "ai", true);

    try {
        console.log("📤 Sending request to Chat Service...");

        const response = await fetch(API_URL, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                message: message,
                session_id: getSessionId()
            })
        });

        console.log("📥 HTTP STATUS:", response.status);

        // lấy raw text trước khi parse JSON
        const rawText = await response.text();
        console.log("📦 RAW RESPONSE:", rawText);

        // nếu lỗi HTTP
        if(!response.ok){
            throw new Error("HTTP ERROR " + response.status + " → " + rawText);
        }

        // parse JSON thủ công để bắt lỗi
        let data;
        try {
            data = JSON.parse(rawText);
        } catch(parseErr){
            throw new Error("JSON PARSE ERROR → " + rawText);
        }

        removeMessage(loadingId);

        if(!data.reply){
            throw new Error("API trả JSON nhưng thiếu field 'reply'");
        }

        addMessage(data.reply, "ai");

    } catch (error) {

        console.error("❌ CHAT SERVICE ERROR:", error);

        removeMessage(loadingId);

        // hiển thị lỗi thật lên UI luôn
        addMessage("LỖI: " + error.message, "ai");
    }
}


// ================= UI =================
function addMessage(text, sender, isTemp = false){
    const box = document.getElementById("chat-messages");

    const div = document.createElement("div");
    div.className = sender === "user" ? "msg-user" : "msg-ai";
    div.innerText = text;

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

function removeMessage(id){
    const el = document.getElementById(id);
    if(el) el.remove();
}


// ================= SESSION =================
function getSessionId(){
    let session = localStorage.getItem("chat_session");
    if(!session){
        session = "sess_" + Math.random().toString(36).substring(2,10);
        localStorage.setItem("chat_session", session);
    }
    return session;
}