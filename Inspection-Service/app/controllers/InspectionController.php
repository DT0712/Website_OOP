<?php
require_once __DIR__ . '/../models/Inspection.php';
require_once __DIR__ . '/../helpers/Response.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class InspectionController {
    private $model;
    private $bicycle_service_url = "http://localhost/Website_OOP/Website_OOP/Guest/bicycle.php";

    public function __construct() {
        $this->model = new Inspection();
    }

    public function createReport() {
        $user = AuthMiddleware::requireRole('inspector');
        $body = json_decode(file_get_contents("php://input"), true);

        $required = [
            'bicycle_id', 'frame_condition', 'brake_condition',
            'drivetrain_condition', 'tire_condition', 'overall_score'
        ];
        foreach ($required as $field) {
            if (!isset($body[$field]) || $body[$field] === '') {
                Response::error("Thiếu trường bắt buộc: {$field}");
            }
        }

        if ($body['overall_score'] < 0 || $body['overall_score'] > 100) {
            Response::error("overall_score phải từ 0 đến 100");
        }

        $valid_conditions = ['good', 'fair', 'poor'];
        foreach (['frame_condition','brake_condition','drivetrain_condition','tire_condition'] as $f) {
            if (!in_array($body[$f], $valid_conditions)) {
                Response::error("{$f} phải là: good, fair, hoặc poor");
            }
        }

        // Verify xe tồn tại qua API
        $bicycle_id   = (int)$body['bicycle_id'];
        $bicycle_info = $this->getBicycleFromService($bicycle_id);
        if (!$bicycle_info) {
            Response::error("Xe #$bicycle_id không tồn tại trong hệ thống.", 404);
        }

        $report_file = null;
        if (!empty($_FILES['report_file']['name'])) {
            $report_file = $this->handleFileUpload($_FILES['report_file']);
        }

        $new_id = $this->model->createReport([
            'bicycle_id'           => $bicycle_id,
            'inspector_id'         => $user['id'],
            'frame_condition'      => $body['frame_condition'],
            'brake_condition'      => $body['brake_condition'],
            'drivetrain_condition' => $body['drivetrain_condition'],
            'tire_condition'       => $body['tire_condition'],
            'overall_score'        => (int)$body['overall_score'],
            'notes'                => $body['notes'] ?? null,
            'report_file'          => $report_file,
        ]);

        $report = $this->model->getById($new_id);
        $report['bicycle_info'] = $bicycle_info;

        Response::success("Tạo báo cáo kiểm định thành công", $report, 201);
    }

    public function getByBicycle(int $bicycle_id) {
        if ($bicycle_id <= 0) {
            Response::error("bicycle_id không hợp lệ");
        }

        $reports      = $this->model->getByBicycleId($bicycle_id);
        $is_verified  = false;
        foreach ($reports as $r) {
            if ($r['status'] === 'approved') { $is_verified = true; break; }
        }

        $bicycle_info = $this->getBicycleFromService($bicycle_id);

        Response::success("OK", [
            'bicycle_id'   => $bicycle_id,
            'bicycle_info' => $bicycle_info,
            'is_verified'  => $is_verified,
            'total'        => count($reports),
            'reports'      => $reports
        ]);
    }

    public function approveReport() {
        $user      = AuthMiddleware::requireRole('admin');
        $body      = json_decode(file_get_contents("php://input"), true);
        $report_id = (int)($body['report_id'] ?? 0);

        if ($report_id <= 0) {
            Response::error("Thiếu report_id");
        }

        $affected = $this->model->approveReport($report_id, $user['id']);
        if ($affected === 0) {
            Response::error("Không tìm thấy báo cáo hoặc đã được duyệt rồi", 404);
        }

        $report = $this->model->getById($report_id);
        Response::success("Báo cáo đã được duyệt. Xe được gắn nhãn ✅ Verified", $report);
    }

    public function rejectReport() {
        $user      = AuthMiddleware::requireRole('admin');
        $body      = json_decode(file_get_contents("php://input"), true);
        $report_id = (int)($body['report_id'] ?? 0);

        if ($report_id <= 0) {
            Response::error("Thiếu report_id");
        }

        $affected = $this->model->rejectReport($report_id, $user['id']);
        if ($affected === 0) {
            Response::error("Không tìm thấy báo cáo hoặc đã xử lý rồi", 404);
        }

        $report = $this->model->getById($report_id);
        Response::success("Đã từ chối báo cáo #$report_id", $report);
    }

    // Admin lấy danh sách tất cả báo cáo
    public function getAllReports() {
        $filter  = $_GET['filter'] ?? 'all';
        $reports = $this->model->getAllReports($filter);
        $stats   = $this->model->getStats();

        Response::success("OK", [
            'filter'  => $filter,
            'stats'   => $stats,
            'total'   => count($reports),
            'reports' => $reports
        ]);
    }

    // Tổng quan thống kê + recent cho inspection_management
    public function getStats() {
        $stats  = $this->model->getStats();
        $recent = $this->model->getRecent(5);

        Response::success("OK", [
            'stats'  => $stats,
            'recent' => $recent
        ]);
    }

    // Private helpers 
    private function getBicycleFromService(int $bicycle_id): ?array {
        $url     = $this->bicycle_service_url . "?id=" . $bicycle_id;
        $context = stream_context_create([
            'http' => ['method' => 'GET', 'timeout' => 5, 'ignore_errors' => true]
        ]);
        $resp = @file_get_contents($url, false, $context);
        if (!$resp) return null;
        $data = json_decode($resp, true);
        return ($data['success'] ?? false) ? ($data['data'] ?? null) : null;
    }

    private function handleFileUpload(array $file): string {
        $allowed = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!in_array($file['type'], $allowed)) {
            Response::error("Chỉ cho phép JPG, PNG, PDF");
        }
        if ($file['size'] > 5 * 1024 * 1024) {
            Response::error("File tối đa 5MB");
        }
        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('report_') . '.' . $ext;
        $dest     = __DIR__ . '/../uploads/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            Response::error("Upload file thất bại", 500);
        }
        return 'uploads/' . $filename;
    }
}