<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// xử lý preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$services = require __DIR__ . '/../config/services.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/swagger') {
    require __DIR__ . '/swagger.php';
    exit;
}

if ($uri === '/swagger.json') {
    header('Content-Type: application/json');
    readfile(__DIR__ . '/swagger.json');
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

$parts = explode('/', trim($uri, '/'));

// Validate API
if (($parts[0] ?? null) !== 'api') {
    http_response_code(404);
    echo json_encode(["error" => "Invalid API"]);
    exit;
}

$serviceName = $parts[1] ?? null;
$path = implode('/', array_slice($parts, 2));

if (!isset($services[$serviceName])) {
    http_response_code(404);
    echo json_encode(["error" => "Service not found"]);
    exit;
}

// Build target URL
$query = $_SERVER['QUERY_STRING'] ?? '';
$target = rtrim($services[$serviceName], '/') . '/' . $path;

if ($query) {
    $target .= '?' . $query;
}

// Init CURL
$ch = curl_init($target);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST  => $method,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT        => 15,
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_ENCODING       => '',
]);

// ==========================
// HANDLE BODY
// ==========================
if (in_array($method, ['POST', 'PUT', 'PATCH'])) {

    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    $convertedToUrlencoded = false;

    if (strpos($contentType, 'multipart/form-data') !== false) {
        if (!empty($_FILES)) {
            // Multipart FormData with files
            $postData = [];

            foreach ($_FILES as $key => $file) {
                $postData[$key] = new CURLFile(
                    $file['tmp_name'],
                    $file['type'],
                    $file['name']
                );
            }

            foreach ($_POST as $key => $value) {
                $postData[$key] = $value;
            }

            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        } elseif (!empty($_POST)) {
            // Browser FormData with only text fields
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));
            $convertedToUrlencoded = true;
        } else {
            // Multipart data with no parsed fields; fallback to raw body
            $rawInput = file_get_contents("php://input");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $rawInput);
        }

    } elseif (!empty($_FILES)) {
        // File upload case (legacy)
        $postData = [];

        // forward files
        foreach ($_FILES as $key => $file) {
            $postData[$key] = new CURLFile(
                $file['tmp_name'],
                $file['type'],
                $file['name']
            );
        }

        // forward form fields
        foreach ($_POST as $key => $value) {
            $postData[$key] = $value;
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    } elseif (!empty($_POST)) {
        // Form data case - convert to urlencoded
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));

    } else {
        // Raw body case (JSON, etc.)
        $rawInput = file_get_contents("php://input");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $rawInput);
    }
}

// ==========================
// HANDLE HEADERS
// ==========================
$headers = getallheaders();
$forwardHeaders = [];

// Check if multipart and set Content-Type
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
$isMultipart = strpos($contentType, 'multipart/form-data') !== false;

foreach ($headers as $key => $value) {
    $keyLower = strtolower($key);

    if ($keyLower === 'host') continue;
    if ($keyLower === 'content-length') continue;
    if ($keyLower === 'transfer-encoding') continue;
    if ($isMultipart && $keyLower === 'content-type') continue; // Skip, will add back appropriately

    $forwardHeaders[] = "$key: $value";
}

if ($isMultipart) {
    if (!empty($convertedToUrlencoded)) {
        $forwardHeaders[] = "Content-Type: application/x-www-form-urlencoded";
    }
}

curl_setopt($ch, CURLOPT_HTTPHEADER, $forwardHeaders);

// ==========================
// EXECUTE
// ==========================
$response = curl_exec($ch);
$error = curl_error($ch);

if ($response === false) {
    http_response_code(500);
    echo json_encode([
        "error" => "Gateway error",
        "message" => $error
    ]);
    exit;
}

// Forward status code
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
http_response_code($statusCode);

// Forward response
echo $response;