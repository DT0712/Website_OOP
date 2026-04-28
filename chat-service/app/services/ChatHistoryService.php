<?php
require_once __DIR__ . '/../models/Message.php';

class ChatHistoryService {

    public static function saveUserMessage($msg){
        Message::save("user",$msg);
    }

    public static function saveAIMessage($msg){
        Message::save("ai",$msg);
    }

    public static function getHistory(){
        return Message::getAll();
    }
}