<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// route tới user-service
if (strpos($uri, '/users') === 0 || $uri === '/login') {

    $target = "http://localhost:8001" . $uri;

    $ch = curl_init($target);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    // forward body nếu có
    $body = file_get_contents("php://input");
    if ($body) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }

    // forward header
    $headers = [];
    foreach (getallheaders() as $key => $value) {
        $headers[] = "$key: $value";
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    curl_close($ch);

    header("Content-Type: application/json");
    echo $response;
    return;
}

// fallback
http_response_code(404);
echo json_encode(["error" => "Gateway Not Found"]);