const API_CHAT = "http://localhost/chat_service/public/index.php/chat";

function appendMessage(sender,text){
    let box = document.getElementById("chat-messages");
    box.innerHTML += `<div><b>${sender}:</b> ${text}</div>`;
    box.scrollTop = box.scrollHeight;
}

async function sendMessage(){

    let input = document.getElementById("chatText");
    let message = input.value.trim();
    if(!message) return;

    appendMessage("You", message);
    input.value="";

    try{
        const res = await fetch(API_CHAT,{
            method:"POST",
            headers:{ "Content-Type":"application/json" },
            body: JSON.stringify({ message })
        });

        const data = await res.json();
        appendMessage("Bot", data.reply);

    }catch(err){
        appendMessage("Bot","Chat service is offline ❌");
    }
}