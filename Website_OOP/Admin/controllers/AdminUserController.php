<?php

class AdminUserController {

    private $api = "http://localhost:8000/users";

    private function callAPI($url, $method = "GET", $data = null) {

        $ch = curl_init();

        $token = $_SESSION['token'] ?? '';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $headers = ["Content-Type: application/json"];

        if ($token) {
            $headers[] = "Authorization: Bearer $token";
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response ? json_decode($response, true) : [];
    }

    // Danh sách user
    public function index() {

        // if (!isset($_SESSION['token'])) {
        //     echo "Chưa đăng nhập!";
        //     exit;
        // }
        $users = $this->callAPI($this->api);
        require __DIR__ . "/../user_management.php";
    }

    public function show() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Thiếu ID";
            return;
        }

        $user = $this->callAPI($this->api . "/" . $id);

        require __DIR__ . "/../user_detail.php";
    }


    public function edit() {

        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Thiếu ID";
            return;
        }

        // Khi submit form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                "name" => $_POST['name'],
                "email" => $_POST['email'],
                "dien_thoai" => $_POST['phone'],
                "ngay_sinh" => $_POST['ngay_sinh'],
                "dia_chi" => $_POST['dia_chi']
            ];

            if (!empty($_FILES['avatar']['tmp_name'])) {
                $data['avatar'] = new CURLFile(
                    $_FILES['avatar']['tmp_name'],
                    $_FILES['avatar']['type'],
                    $_FILES['avatar']['name']
                );
            }

            $this->callAPI($this->api . "/" . $id, "PUT", $data);

            header("Location: index1.php?page=user_management");
            exit;
        }

        // Load dữ liệu user
        $user = $this->callAPI($this->api . "/" . $id);

        require __DIR__ . "/../user_edit.php";
    }

    // Xóa user
    public function delete() {
        $id = $_GET['id'];
        $this->callAPI($this->api . "/" . $id, "DELETE");

        header("Location: index1.php?page=user_management");
    }

    public function create() {
        require __DIR__ . "/../user_create.php";
    }

    public function store() {

        $data = json_encode([
            "name" => $_POST['name'],
            "email" => $_POST['email'],
            "password" => $_POST['password'],
            "role" => $_POST['role']
        ]);

        $response = $this->callAPI($this->api, "POST", $data);

        header("Location: index1.php?page=user_management");
        exit;
    }
}