<?php
class ApiHelper {

    // Base URL của service — tự động detect
    private static function baseUrl() {
        $protocol = (!empty($_SERVER['HTTPS'])) ? 'https' : 'http';
        $host     = $_SERVER['HTTP_HOST'];
        return $protocol . '://' . $host . '/Website_OOP/InspectionService/index.php';
    }

     //Gọi API với method + endpoint + data + headers
    public static function call(string $method, string $endpoint, array $data = [], array $extra_headers = []) {
        $url = self::baseUrl() . $endpoint;

        // Lấy user từ session (website_oop đã login)
        $user_id   = $_SESSION['user_id']   ?? 0;
        $user_role = $_SESSION['user_role'] ?? 'buyer';

        $headers = array_merge([
            'Content-Type: application/json',
            'X-User-Id: '   . $user_id,
            'X-User-Role: ' . $user_role,
        ], $extra_headers);

        $opts = [
            'http' => [
                'method'        => strtoupper($method),
                'header'        => implode("\r\n", $headers),
                'content'       => json_encode($data),
                'ignore_errors' => true, // đọc cả response lỗi (4xx, 5xx)
            ]
        ];

        $context  = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);

        return json_decode($response, true);
    }

    public static function get(string $endpoint)                         { return self::call('GET',  $endpoint); }
    public static function post(string $endpoint, array $data = [])      { return self::call('POST', $endpoint, $data); }
    public static function put(string $endpoint, array $data = [])       { return self::call('PUT',  $endpoint, $data); }
}