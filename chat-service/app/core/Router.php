<?php
class Router {

    public static function handle() {

        $url = $_GET['url'] ?? '';

        // POST /?url=chat/send
        if ($url === "chat/send" && $_SERVER['REQUEST_METHOD'] === "POST") {
            (new ChatController())->send();
            return;
        }

        echo json_encode(["status" => "Chat Service Running"]);
    }
}