<?php

require_once __DIR__ . '/../core/Database.php';

class User {

    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $sql = "SELECT 
                    id_khach_hang,
                    ho_ten,
                    email,
                    dien_thoai,
                    anh_dai_dien
                FROM khach_hang";

        $result = $this->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM khach_hang WHERE id_khach_hang=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $data) {

        $sql = "UPDATE khach_hang SET ho_ten=?, email=?, dien_thoai=?, ngay_sinh=?, dia_chi=?";

        if (!empty($data['anh_dai_dien'])) {
            $sql .= ", anh_dai_dien=?";
        }

        if (!empty($data['anh_nen'])) {
            $sql .= ", anh_nen=?";
        }

        $sql .= " WHERE id_khach_hang=?";

        $stmt = $this->conn->prepare($sql);

        $ho_ten = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $dien_thoai = $data['dien_thoai'] ?? null;
        $ngay_sinh = $data['ngay_sinh'] ?? null;
        $dia_chi = $data['dia_chi'] ?? null;

        if (!empty($data['anh_dai_dien'])) {

            $anh_dai_dien = $data['anh_dai_dien'];

            if (!empty($data['anh_nen'])) {

                $anh_nen = $data['anh_nen'];

                $stmt->bind_param("sssssssi",
                    $ho_ten,
                    $email,
                    $dien_thoai,
                    $ngay_sinh,
                    $dia_chi,
                    $anh_dai_dien,
                    $anh_nen,
                    $id
                );
            } else {
                $stmt->bind_param("ssssssi",
                    $ho_ten,
                    $email,
                    $dien_thoai,
                    $ngay_sinh,
                    $dia_chi,
                    $anh_dai_dien,
                    $id
                );
            }
        } else {
            if (!empty($data['anh_nen'])) {

                $anh_nen = $data['anh_nen'];

                $stmt->bind_param("ssssssi",
                    $ho_ten,
                    $email,
                    $dien_thoai,
                    $ngay_sinh,
                    $dia_chi,
                    $anh_nen,
                    $id
                );
            } else {

                $stmt->bind_param("sssssi",
                    $ho_ten,
                    $email,
                    $dien_thoai,
                    $ngay_sinh,
                    $dia_chi,
                    $id
                );
            }
        }

        $success = $stmt->execute();

        if (!$success) {
            return ["error" => $stmt->error];
        }

        return ["message" => "User updated"];
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM khach_hang WHERE id_khach_hang=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function create($data) {

        $stmt = $this->conn->prepare("
            INSERT INTO khach_hang (ho_ten, email, dien_thoai, ngay_sinh, dia_chi, anh_dai_dien, anh_nen, mat_khau)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $phone = $data['dien_thoai'] ?? null;
        $ngay_sinh = $data['ngay_sinh'] ?? null;
        $dia_chi = $data['dia_chi'] ?? null;
        $avatar = $data['anh_dai_dien'] ?? null;
        $cover = $data['anh_nen'] ?? null;
        $password = $data['password'] ?? null;

        $stmt->bind_param(
            "ssssssss",
            $name,
            $email,
            $phone,
            $ngay_sinh,
            $dia_chi,
            $avatar,
            $cover,
            $password
        );

        $success = $stmt->execute();

        if (!$success) {
            return ["error" => $stmt->error];
        }

        return ["message" => "User created"];
    }
}