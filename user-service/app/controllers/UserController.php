<?php

require_once __DIR__ . '/../services/UserService.php';

class UserController {

    private $service;

    public function __construct() {
        $this->service = new UserService();
    }

    public function login() {

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data['email'] === 'admin@gmail.com' && $data['password'] === '123') {

            $token = JWT::encode([
                "email" => $data['email'],
                "role" => "admin"
            ]);

            echo json_encode(["token" => $token]);
        } else {
            http_response_code(401);
            echo json_encode(["error" => "Unauthorized"]);
        }
    }

    public function index() {
        $users = $this->service->getUsers();

        header('Content-Type: application/json');
        echo json_encode([
            "data" => $users
        ]);
    }

    public function show($id) {
        $user = $this->service->getUser($id);
        header('Content-Type: application/json');
        echo json_encode($user);
    }

    public function update($id) {

        header('Content-Type: application/json');

        $data = $_POST;

        if (empty($data) && empty($_FILES)) {
            http_response_code(400);
            echo json_encode(["error" => "No data"]);
            return;
        }

        $data['ngay_sinh'] = !empty($data['ngay_sinh']) ? $data['ngay_sinh'] : null;
        $data['dia_chi']   = !empty($data['dia_chi']) ? $data['dia_chi'] : null;

        // nhận path từ FE
        if (isset($data['anh_dai_dien'])) {
            $data['anh_dai_dien'] = $data['anh_dai_dien'];
        }

        if (isset($data['anh_nen'])) {
            $data['anh_nen'] = $data['anh_nen'];
        }

        $result = $this->service->update($id, $data);

        if ($result) {
            echo json_encode([
                "status" => "success",
                "message" => "Updated"
            ]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Update failed"]);
        }
    }

    public function delete($id){
        header('Content-Type: application/json');

        try {
            $deleted = $this->service->deleteUser($id);

            if (!$deleted) {
                http_response_code(404);
                echo json_encode([
                    "message" => "User không tồn tại"
                ]);
                return;
            }

            echo json_encode([
                "message" => "Xóa thành công"
            ]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "message" => "Lỗi server",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function store() {

        header('Content-Type: application/json');

        $data = $_POST;

        if (!$data) {
            http_response_code(400);
            echo json_encode(["error" => "No data"]);
            return;
        }

        // xử lý null
        $data['ngay_sinh'] = !empty($data['ngay_sinh']) ? $data['ngay_sinh'] : null;
        $data['dia_chi']   = !empty($data['dia_chi']) ? $data['dia_chi'] : null;

        // hash password
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // nhận path từ FE
        $data['anh_dai_dien'] = $data['anh_dai_dien'] ?? null;
        if ($data['anh_dai_dien'] && !preg_match('#^uploads/avatars/(suggest/)?[a-zA-Z0-9._-]+$#', $data['anh_dai_dien'])) {
            echo json_encode(["error" => "Avatar không hợp lệ"]);
            exit;
        }

        $data['anh_nen']      = $data['anh_nen'] ?? null;

        // lưu DB
        $result = $this->service->create($data);

        if ($result) {
            echo json_encode([
                "status" => "success",
                "message" => "User created"
            ]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Create failed"]);
        }
    }

    public function uploadAvatar() {

        if (!isset($_FILES['avatar'])) {
            http_response_code(400);
            echo json_encode(["error" => "No file uploaded"]);
            return;
        }

        $file = $_FILES['avatar'];

        // thư mục lưu
        $uploadDir = __DIR__ . '/../../uploads/avatars/';

        // tạo folder nếu chưa có
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // tạo tên file unique
        $fileName = time() . "_" . basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        // move file
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {

            // path lưu DB (relative)
            $dbPath = "uploads/avatars/" . $fileName;

            echo json_encode([
                "success" => true,
                "path" => $dbPath
            ]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Upload failed"]);
        }
    }
}