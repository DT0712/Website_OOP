<?php
require_once __DIR__ . "/config.php";

if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION['user_id']   = 3;
$_SESSION['user_role'] = 'inspector';

$current_page = basename($_SERVER['PHP_SELF']);

$result  = null;
$error   = null;
$success = null;

$bikes_response = @file_get_contents(
    "http://localhost/Website_OOP/Website_OOP/Guest/api/bicycle.php?action=list"
);
$bikes = [];
if ($bikes_response) {
    $bikes_data = json_decode($bikes_response, true);
    $bikes = $bikes_data['data'] ?? [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'bicycle_id'           => (int)($_POST['bicycle_id']           ?? 0),
        'frame_condition'      => $_POST['frame_condition']      ?? '',
        'brake_condition'      => $_POST['brake_condition']      ?? '',
        'drivetrain_condition' => $_POST['drivetrain_condition'] ?? '',
        'tire_condition'       => $_POST['tire_condition']       ?? '',
        'overall_score'        => (int)($_POST['overall_score']  ?? 0),
        'notes'                => $_POST['notes']                ?? '',
    ];

    $opts = [
        'http' => [
            'method'        => 'POST',
            'header'        => "Content-Type: application/json\r\n" .
                               "X-User-Id: {$_SESSION['user_id']}\r\n" .
                               "X-User-Role: {$_SESSION['user_role']}\r\n",
            'content'       => json_encode($data),
            'ignore_errors' => true,
        ]
    ];
    $resp   = @file_get_contents(
        "http://localhost/Website_OOP/InspectionService/public/index.php/inspection/report",
        false,
        stream_context_create($opts)
    );
    $result = json_decode($resp, true);

    if ($result['success'] ?? false) {
        $bike_name = $result['data']['bicycle_info']['name'] ?? "Xe #{$data['bicycle_id']}";
        $success   = "Đã tạo báo cáo kiểm định thành công cho: <strong>$bike_name</strong>";
    } else {
        $error = $result['message'] ?? 'Có lỗi xảy ra.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Tạo Báo Cáo Kiểm Định — Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
/* CSS sidebar/main do teammate quản lý — KHÔNG define lại ở đây */
body { background: #f5f7fb; display: flex; }

/* ── CSS riêng của trang này ── */
.form-card {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    overflow: hidden; max-width: 720px;
}
.form-card-header {
    background: linear-gradient(90deg,#6c5ce7,#5b5ce2);
    color: white; padding: 16px 24px; font-weight: 600; font-size: 15px;
}
.check-group {
    border: 1px solid #eee; border-radius: 10px;
    padding: 16px; margin-bottom: 12px;
}
.check-group-label { font-weight: 600; font-size: 13px; margin-bottom: 10px; color: #444; }
.condition-options { display: flex; gap: 8px; }
.condition-option  { flex: 1; }
.condition-option input[type="radio"] { display: none; }
.condition-option label {
    display: block; text-align: center; padding: 9px;
    border: 2px solid #eee; border-radius: 8px;
    cursor: pointer; font-size: 13px; transition: all 0.15s;
}
.condition-option input[value="good"]:checked + label { border-color:#059669; background:#d1fae5; color:#065f46; }
.condition-option input[value="fair"]:checked + label { border-color:#d97706; background:#fef3c7; color:#92400e; }
.condition-option input[value="poor"]:checked + label { border-color:#dc2626; background:#fee2e2; color:#991b1b; }
.condition-option label:hover { border-color: #5b5ce2; }

#scoreDisplay { font-size: 26px; font-weight: bold; color: #5b5ce2; }
.score-bar { accent-color: #5b5ce2; }

.bike-preview {
    display: none; background: #f8f9ff; border: 1px solid #e0e0f0;
    border-radius: 8px; padding: 12px 16px; margin-top: 8px; font-size: 13px;
}
.bike-preview.show { display: flex; align-items: center; gap: 12px; }
.bike-preview-name { font-weight: 600; color: #333; }
.bike-preview-meta { color: #888; font-size: 11px; }

.btn-submit {
    background: linear-gradient(90deg,#6c5ce7,#5b5ce2);
    color: white; border: none; padding: 10px 30px;
    border-radius: 10px; font-weight: 600; cursor: pointer; font-size: 14px; transition: 0.2s;
}
.btn-submit:hover { opacity: 0.9; transform: translateY(-1px); }

.api-badge {
    display: inline-block; background: #e8e8ff; color: #5b5ce2;
    border: 1px solid #c4c4f0; border-radius: 12px;
    padding: 2px 10px; font-size: 11px; margin-left: 8px;
}
.section-divider { border-bottom: 1px solid #e1d9d9; margin: 15px 0; }
</style>
</head>
<body>

<?php include __DIR__ . "/sidebar.php"; ?>

<div class="main" style="margin-left:270px; padding:28px 32px; flex:1;">
    <h3 class="mb-1">🔍 Tạo Báo Cáo Kiểm Định</h3>
    <p class="text-muted mb-3" style="font-size:13px;">
        Inspector #<?= $_SESSION['user_id'] ?> — Điền đầy đủ checklist kỹ thuật
        <span class="badge rounded-pill ms-2" style="background:#e8e8ff;color:#5b5ce2;font-size:11px;">
            Inspection Service API
        </span>
    </p>
    <div class="section-divider"></div>

    <?php if ($success): ?>
        <div class="alert alert-success py-2 mb-3" style="font-size:13px;max-width:720px">
            ✅ <?= $success ?>
            <?php if (!empty($result['data']['id'])): ?>
                <br><small>Mã báo cáo: <strong>#<?= $result['data']['id'] ?></strong> — Chờ Admin duyệt</small>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger py-2 mb-3" style="font-size:13px;max-width:720px">
            ❌ <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <div class="form-card-header">
            <i class="fa fa-clipboard-check me-2"></i>Checklist Kiểm Định Xe Đạp
        </div>
        <div class="p-4">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:13px;">
                        Chọn xe cần kiểm định
                        <span class="api-badge">🔗 Load từ Guest/api/bicycle.php</span>
                    </label>
                    <?php if (empty($bikes)): ?>
                        <input type="number" name="bicycle_id" class="form-control form-control-sm"
                               placeholder="Nhập Bicycle ID" min="1" required
                               value="<?= htmlspecialchars($_POST['bicycle_id'] ?? '') ?>">
                        <div class="form-text text-warning">⚠️ Không kết nối được Bicycle Service</div>
                    <?php else: ?>
                        <select name="bicycle_id" class="form-select form-select-sm"
                                required onchange="previewBike(this)">
                            <option value="">-- Chọn xe --</option>
                            <?php foreach ($bikes as $bike): ?>
                                <option value="<?= $bike['bicycle_id'] ?>"
                                        data-name="<?= htmlspecialchars($bike['name']) ?>"
                                        data-price="<?= number_format($bike['price']) ?>"
                                        data-size="<?= htmlspecialchars($bike['frame_size']) ?>"
                                        data-condition="<?= htmlspecialchars($bike['condition_status']) ?>"
                                        <?= (($_POST['bicycle_id'] ?? '') == $bike['bicycle_id']) ? 'selected' : '' ?>>
                                    #<?= $bike['bicycle_id'] ?> — <?= htmlspecialchars($bike['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="bike-preview" id="bikePreview">
                            <span style="font-size:24px">🚲</span>
                            <div>
                                <div class="bike-preview-name" id="previewName"></div>
                                <div class="bike-preview-meta" id="previewMeta"></div>
                            </div>
                        </div>
                        <div class="form-text">✅ <?= count($bikes) ?> xe từ hệ thống</div>
                    <?php endif; ?>
                </div>

                <hr class="my-3">
                <p class="fw-semibold mb-3" style="font-size:13px;color:#555;">
                    Đánh giá từng bộ phận:
                    <span class="text-success">Tốt</span> /
                    <span class="text-warning">Trung bình</span> /
                    <span class="text-danger">Kém</span>
                </p>

                <?php foreach ([
                    'frame_condition'      => '🔧 Khung xe (Frame)',
                    'brake_condition'      => '🛑 Phanh (Brake)',
                    'drivetrain_condition' => '⚙️ Truyền động (Drivetrain)',
                    'tire_condition'       => '🔵 Lốp xe (Tire)',
                ] as $name => $label): ?>
                <div class="check-group">
                    <div class="check-group-label"><?= $label ?></div>
                    <div class="condition-options">
                        <?php foreach (['good'=>'✅ Tốt','fair'=>'⚠️ Trung bình','poor'=>'❌ Kém'] as $val=>$lbl): ?>
                        <div class="condition-option">
                            <input type="radio" name="<?= $name ?>"
                                   id="<?= $name ?>_<?= $val ?>" value="<?= $val ?>" required
                                   <?= (($_POST[$name] ?? '') === $val) ? 'checked' : '' ?>>
                            <label for="<?= $name ?>_<?= $val ?>"><?= $lbl ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <hr class="my-3">

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:13px;">
                        Điểm tổng thể: <span id="scoreDisplay"><?= $_POST['overall_score'] ?? 80 ?></span>/100
                    </label>
                    <input type="range" name="overall_score" class="form-range score-bar"
                           min="0" max="100" value="<?= $_POST['overall_score'] ?? 80 ?>"
                           oninput="document.getElementById('scoreDisplay').textContent = this.value">
                    <div class="d-flex justify-content-between" style="font-size:11px;color:#aaa;">
                        <span>0 — Hỏng nặng</span><span>50 — Trung bình</span><span>100 — Như mới</span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold" style="font-size:13px;">Ghi chú thêm</label>
                    <textarea name="notes" class="form-control form-control-sm" rows="3"
                              placeholder="VD: Phanh sau mòn nhẹ, cần thay trong 2-3 tháng..."
                    ><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Báo cáo chờ Admin duyệt trước khi hiển thị cho Buyer</small>
                    <button type="submit" class="btn-submit">
                        <i class="fa fa-paper-plane me-2"></i>Gửi Báo Cáo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewBike(select) {
    const opt = select.options[select.selectedIndex];
    const preview = document.getElementById('bikePreview');
    if (!opt.value) { preview.classList.remove('show'); return; }
    document.getElementById('previewName').textContent = opt.dataset.name;
    document.getElementById('previewMeta').textContent =
        `Size: ${opt.dataset.size} · ${opt.dataset.condition} · ${opt.dataset.price} VNĐ`;
    preview.classList.add('show');
}
window.addEventListener('DOMContentLoaded', () => {
    const sel = document.querySelector('select[name="bicycle_id"]');
    if (sel && sel.value) previewBike(sel);
});
</script>
</body>
</html>