<?php

require_once '../app/controllers/FileController.php';
$controller = new FileController();
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// nếu request tới uploads
if (strpos($uri, '/uploads/') === 0) {

    $file = __DIR__ . '/../storage' . $uri;

    if (file_exists($file)) {
        header('Content-Type: ' . mime_content_type($file));
        readfile($file);
        exit;
    } else {
        http_response_code(404);
        echo "File not found";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'upload') {

    header('Content-Type: application/json');

    if (empty($_FILES['file']['name'])) {
        echo json_encode(["error" => "No file"]);
        exit;
    }

    // check lỗi upload
    if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["error" => "Upload failed"]);
        exit;
    }

    // chỉ cho phép ảnh
    $allowed = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        echo json_encode(["error" => "Invalid file type"]);
        exit;
    }

    $type = $_GET['type'] ?? 'avatar';
    $folder = ($type === 'cover') ? 'covers' : 'avatars';

    $uploadDir = __DIR__ . '/../storage/uploads/' . $folder . '/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = time() . '_' . uniqid() . '.' . $ext;
    $targetFile = $uploadDir . $fileName;

    if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        echo json_encode(["error" => "Cannot save file"]);
        exit;
    }

    // XÓA ẢNH CŨ
    if (!empty($_POST['old_path'])) {

        $oldPath = $_POST['old_path'];

        // KHÔNG xóa ảnh trong thư mục suggest
        if (strpos($oldPath, 'suggest') === false) {

            $oldFile = realpath(__DIR__ . '/../storage/' . $oldPath);
            $storageRoot = realpath(__DIR__ . '/../storage/');

            // đảm bảo file nằm trong storage
            if ($oldFile && strpos($oldFile, $storageRoot) === 0 && file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
    }

    echo json_encode([
        "status" => "success",
        "path" => "uploads/" . $folder . "/" . $fileName
    ]);
}

if (strpos($uri, '/delete') !== false) {
    $controller->delete();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($_GET['action'] ?? '') === 'list') {

    header('Content-Type: application/json');

    $type = $_GET['type'] ?? '';

    if ($type === 'suggest') {

        $dir = __DIR__ . '/../storage/uploads/avatars/suggest/';
        $baseUrl = "http://localhost/website_oop/file-service/storage/uploads/avatars/suggest/";

        if (!is_dir($dir)) {
            echo json_encode([
                "status" => "error",
                "message" => "Folder không tồn tại"
            ]);
            exit;
        }

        $files = array_values(array_diff(scandir($dir), ['.', '..']));

        $images = array_filter($files, function($file) {
            return preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
        });

        $result = array_map(function($file) use ($baseUrl) {
            return [
                "name" => $file,
                "url" => $baseUrl . $file,
                "path" => "uploads/avatars/suggest/" . $file
            ];
        }, $images);

        echo json_encode([
            "status" => "success",
            "files" => $result
        ]);
        exit;
    }
}