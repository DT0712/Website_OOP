<?php 
require_once __DIR__ . '/../models/Message.php';

class ChatHistoryService {

    public static function saveUserMessage($session, $msg){
        Message::save($session, "user", $msg);
    }

    public static function saveAIMessage($session, $msg){
        Message::save($session, "ai", $msg);
    }

    public static function getHistory($session){
        return Message::getBySession($session);
    }
}