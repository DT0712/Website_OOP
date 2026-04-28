<?php
class ChatController {

    public function send() {

        $input = json_decode(file_get_contents("php://input"), true);

        $message = $input["message"] ?? "";
        $session = $input["session_id"] ?? "guest";

        if(!$message){
            echo json_encode(["reply"=>"No message"]);
            return;
        }

        // 1️⃣ lưu tin nhắn user
        Message::save($session,"user",$message);

        // 2️⃣ lấy lịch sử chat
        $history = Message::getBySession($session);

        // 3️⃣ gọi AI
        $reply = AIService::ask($history,$message);

        // 4️⃣ lưu reply AI
        Message::save($session,"ai",$reply);

        echo json_encode(["reply"=>$reply]);
    }
}