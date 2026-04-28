<?php
class Response {

    public static function success($message, $data = null, $code = 200) {
        http_response_code($code);
        header('Content-Type: application/json');
        $body = [
            "success" => true,
            "message" => $message
        ];
        if ($data !== null) {
            $body["data"] = $data;
        }
        echo json_encode($body, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function error($message, $code = 400) {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode([
            "success" => false,
            "message" => $message
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}