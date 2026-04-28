<?php
require_once __DIR__ . '/../models/Inspection.php';
require_once __DIR__ . '/../helpers/Response.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class InspectionController {
    private $model;

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
            if (empty($body[$field])) {
                Response::error("Thiếu trường bắt buộc: {$field}");
            }
        }

        if ($body['overall_score'] < 0 || $body['overall_score'] > 100) {
            Response::error("overall_score phải từ 0 đến 100");
        }

        $valid_conditions = ['good', 'fair', 'poor'];
        $condition_fields = [
            'frame_condition', 'brake_condition',
            'drivetrain_condition', 'tire_condition'
        ];
        foreach ($condition_fields as $field) {
            if (!in_array($body[$field], $valid_conditions)) {
                Response::error("{$field} phải là: good, fair, hoặc poor");
            }
        }

        $report_file = null;
        if (!empty($_FILES['report_file'])) {
            $report_file = $this->handleFileUpload($_FILES['report_file']);
        }

        $data = [
            'bicycle_id'           => (int)$body['bicycle_id'],
            'inspector_id'         => $user['id'],
            'frame_condition'      => $body['frame_condition'],
            'brake_condition'      => $body['brake_condition'],
            'drivetrain_condition' => $body['drivetrain_condition'],
            'tire_condition'       => $body['tire_condition'],
            'overall_score'        => (int)$body['overall_score'],
            'notes'                => $body['notes']       ?? null,
            'report_file'          => $report_file
        ];

        $new_id = $this->model->createReport($data);
        $report = $this->model->getById($new_id);

        Response::success("Tạo báo cáo kiểm định thành công", $report, 201);
    }

    public function getByBicycle(int $bicycle_id) {
        if ($bicycle_id <= 0) {
            Response::error("bicycle_id không hợp lệ");
        }

        $reports = $this->model->getByBicycleId($bicycle_id);

        $is_verified = false;
        foreach ($reports as $r) {
            if ($r['status'] === 'approved') {
                $is_verified = true;
                break;
            }
        }

        Response::success("OK", [
            'bicycle_id'  => $bicycle_id,
            'is_verified' => $is_verified,
            'total'       => count($reports),
            'reports'     => $reports
        ]);
    }

    public function approveReport() {
        $user = AuthMiddleware::requireRole('admin');

        $body = json_decode(file_get_contents("php://input"), true);

        if (empty($body['report_id'])) {
            Response::error("Thiếu report_id");
        }

        $report_id = (int)$body['report_id'];

        $affected = $this->model->approveReport($report_id, $user['id']);

        if ($affected === 0) {
            Response::error("Không tìm thấy báo cáo hoặc báo cáo đã được duyệt", 404);
        }

        $report = $this->model->getById($report_id);
        Response::success("Báo cáo đã được duyệt. Xe được gắn nhãn ✅ Verified", $report);
    }

    private function handleFileUpload(array $file) {
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