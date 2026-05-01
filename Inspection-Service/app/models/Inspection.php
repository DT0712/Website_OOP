<?php
require_once __DIR__ . '/../config/database.php';

class Inspection {
    private $conn;
    private $table = "inspection_reports";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

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
            ':notes'                => $data['notes']       ?? null,
            ':report_file'          => $data['report_file'] ?? null,
        ]);
        return $this->conn->lastInsertId();
    }

    public function getByBicycleId(int $bicycle_id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table}
             WHERE bicycle_id = :bicycle_id
             ORDER BY created_at DESC"
        );
        $stmt->execute([':bicycle_id' => $bicycle_id]);
        return $stmt->fetchAll();
    }

    public function approveReport(int $report_id, int $admin_id) {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table}
             SET status = 'approved', approved_by = :admin_id, approved_at = NOW()
             WHERE id = :id AND status = 'pending'"
        );
        $stmt->execute([':admin_id' => $admin_id, ':id' => $report_id]);
        return $stmt->rowCount();
    }

    public function rejectReport(int $report_id, int $admin_id) {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table}
             SET status = 'rejected', approved_by = :admin_id, approved_at = NOW()
             WHERE id = :id AND status = 'pending'"
        );
        $stmt->execute([':admin_id' => $admin_id, ':id' => $report_id]);
        return $stmt->rowCount();
    }

    public function getById(int $id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table} WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getAllReports(string $status = 'all') {
        if ($status === 'all') {
            $stmt = $this->conn->query(
                "SELECT * FROM {$this->table} ORDER BY created_at DESC"
            );
        } else {
            $stmt = $this->conn->prepare(
                "SELECT * FROM {$this->table}
                 WHERE status = :status ORDER BY created_at DESC"
            );
            $stmt->execute([':status' => $status]);
        }
        return $stmt->fetchAll();
    }

    // ── Thêm mới: Thống kê theo status ──────────────────────
    public function getStats() {
        $rows = $this->conn->query(
            "SELECT status, COUNT(*) as cnt
             FROM {$this->table} GROUP BY status"
        )->fetchAll();

        $stats = ['pending' => 0, 'approved' => 0, 'rejected' => 0, 'total' => 0];
        foreach ($rows as $r) {
            $stats[$r['status']] = (int)$r['cnt'];
            $stats['total']     += (int)$r['cnt'];
        }
        return $stats;
    }

    // ── Thêm mới: 5 báo cáo mới nhất ────────────────────────
    public function getRecent(int $limit = 5) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table}
             ORDER BY created_at DESC LIMIT :limit"
        );
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}