<?php
require_once __DIR__ . '/../config/database.php';

class Inspection {
    private $conn;
    private $table = "inspection_reports";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Inspector tạo báo cáo mới
    public function createReport(array $data) {
        $sql = "INSERT INTO {$this->table}
                    (bicycle_id, inspector_id,
                     frame_condition, brake_condition,
                     drivetrain_condition, tire_condition,
                     overall_score, notes, report_file)
                VALUES
                    (:bicycle_id, :inspector_id,
                     :frame_condition, :brake_condition,
                     :drivetrain_condition, :tire_condition,
                     :overall_score, :notes, :report_file)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':bicycle_id'           => $data['bicycle_id'],
            ':inspector_id'         => $data['inspector_id'],
            ':frame_condition'      => $data['frame_condition'],
            ':brake_condition'      => $data['brake_condition'],
            ':drivetrain_condition' => $data['drivetrain_condition'],
            ':tire_condition'       => $data['tire_condition'],
            ':overall_score'        => $data['overall_score'],
            ':notes'                => $data['notes']        ?? null,
            ':report_file'          => $data['report_file']  ?? null,
        ]);

        return $this->conn->lastInsertId();
    }

    // Lấy tất cả báo cáo của 1 chiếc xe
    public function getByBicycleId(int $bicycle_id) {
        $sql  = "SELECT * FROM {$this->table}
                 WHERE bicycle_id = :bicycle_id
                 ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':bicycle_id' => $bicycle_id]);
        return $stmt->fetchAll();
    }

    // Admin duyệt báo cáo
    public function approveReport(int $report_id, int $admin_id) {
        $sql  = "UPDATE {$this->table}
                 SET status      = 'approved',
                     approved_by = :admin_id,
                     approved_at = NOW()
                 WHERE id = :id AND status = 'pending'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':admin_id' => $admin_id,
            ':id'       => $report_id
        ]);
        // rowCount() = số dòng bị ảnh hưởng
        // Nếu = 0 nghĩa là report không tồn tại hoặc đã được duyệt rồi
        return $stmt->rowCount();
    }

    // Lấy 1 report theo id (dùng để trả về sau khi tạo/approve)
    public function getById(int $id) {
        $sql  = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}