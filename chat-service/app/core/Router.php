<?php
require_once __DIR__ . '/../controllers/ChatController.php';

class Router {

    public static function handle() {

        // lấy path thật từ URL
        $request = $_SERVER['REQUEST_URI'];
        $script  = $_SERVER['SCRIPT_NAME'];

        // bỏ phần /public/index.php khỏi URL
        $path = str_replace(dirname($script), '', $request);
        $path = trim($path, '/');

        // debug thử nếu muốn
        // echo $path; exit;

        // ===== ROUTES =====
        if ($path === "chat/send" && $_SERVER['REQUEST_METHOD'] === "POST") {
            (new ChatController())->send();
            return;
        }

        // route mặc định
        echo json_encode([
            "status" => "Chat Service Running",
            "route"  => $path
        ]);
    }
}