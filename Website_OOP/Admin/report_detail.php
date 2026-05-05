<?php
require_once __DIR__ . "/config.php";

if (session_status() === PHP_SESSION_NONE) session_start();
$current_page = basename($_SERVER['PHP_SELF']);

$bicycle_id = (int)($_GET['bicycle_id'] ?? 0);
$data       = null;
$error      = null;

if ($bicycle_id > 0) {
    $opts = ['http' => [
        'method'        => 'GET',
        'header'        => "X-User-Id: " . ($_SESSION['user_id'] ?? 1) . "\r\nX-User-Role: " . ($_SESSION['user_role'] ?? 'buyer') . "\r\n",
        'ignore_errors' => true,
    ]];
    $resp   = @file_get_contents(
        "http://localhost/Website_OOP/Inspection-Service/public/index.php/inspection/$bicycle_id",
        false, stream_context_create($opts)
    );
    $result = json_decode($resp, true);
    if ($result['success'] ?? false) {
        $data = $result['data'];
    } else {
        $error = $result['message'] ?? 'Không tải được báo cáo.';
    }
}

function conditionBadge(string $cond): string {
    return match($cond) {
        'good'  => '<span class="badge bg-success-subtle text-success px-2 rounded-pill">✅ Tốt</span>',
        'fair'  => '<span class="badge bg-warning-subtle text-warning px-2 rounded-pill">⚠️ TB</span>',
        'poor'  => '<span class="badge bg-danger-subtle text-danger px-2 rounded-pill">❌ Kém</span>',
        default => '<span class="badge bg-secondary-subtle text-secondary px-2 rounded-pill">—</span>',
    };
}
function scoreColor(int $score): array {
    if ($score >= 80) return ['#059669', '#d1fae5'];
    if ($score >= 50) return ['#d97706', '#fef3c7'];
    return ['#dc2626', '#fee2e2'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Báo Cáo Kiểm Định — Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>

body { background: #f5f7fb; display: flex; }

.verified-banner {
    background: linear-gradient(135deg,#d1fae5,#a7f3d0);
    border: 2px solid #059669; border-radius: 14px;
    padding: 20px 24px; display: flex; align-items: center; gap: 16px; margin-bottom: 20px;
}
.verified-icon { width:56px; height:56px; background:#059669; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:26px; flex-shrink:0; }
.not-verified-banner {
    background: #f8f9fa; border: 2px solid #dee2e6; border-radius: 14px;
    padding: 20px 24px; display: flex; align-items: center; gap: 16px; margin-bottom: 20px;
}
.not-verified-icon { width:56px; height:56px; background:#6c757d; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:26px; flex-shrink:0; }

.report-card { background:white; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); margin-bottom:16px; overflow:hidden; }
.report-card-header {
    background: #f8f9ff; border-bottom: 1px solid #eee;
    padding: 12px 20px; display: flex; justify-content: space-between;
    align-items: center; font-size: 13px; font-weight: 600; color: #444;
}
.score-circle { width:76px; height:76px; border-radius:50%; display:flex; flex-direction:column; align-items:center; justify-content:center; border:4px solid; flex-shrink:0; }
.score-number { font-size:24px; font-weight:bold; line-height:1; }
.score-label  { font-size:9px; opacity:0.7; }
.check-row { display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #f5f5f5; font-size:13px; }
.check-row:last-child { border-bottom:none; }
.search-card { background:white; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); padding:20px; max-width:500px; margin-bottom:24px; }
.bike-info-card { background:#f8f9ff; border:1px solid #e0e0f0; border-radius:12px; padding:16px 20px; margin-bottom:16px; display:flex; align-items:center; gap:14px; }
.api-badge { display:inline-block; background:#e8e8ff; color:#5b5ce2; border:1px solid #c4c4f0; border-radius:10px; padding:1px 8px; font-size:10px; margin-left:6px; }
.status-pill { padding:4px 12px; border-radius:20px; font-size:11px; font-weight:600; }
.status-pending  { background:#fef3c7; color:#92400e; }
.status-approved { background:#d1fae5; color:#065f46; }
.status-rejected { background:#fee2e2; color:#991b1b; }
.section-divider { border-bottom:1px solid #e1d9d9; margin:15px 0; }
</style>
</head>
<body>

<?php include __DIR__ . "/sidebar.php"; ?>

<div class="main" style="margin-left:270px; padding:28px 32px; flex:1;">
    <h3 class="mb-1">🚲 Báo Cáo Kiểm Định Xe</h3>
    <p class="text-muted mb-3" style="font-size:13px;">
        Thông tin kiểm định độc lập — đảm bảo minh bạch giao dịch
        <span class="badge rounded-pill ms-2" style="background:#e8e8ff;color:#5b5ce2;font-size:11px;">Inspection Service API</span>
    </p>
    <div class="section-divider"></div>

    <div class="search-card">
        <form method="GET" class="d-flex gap-2">
            <input type="number" name="bicycle_id" class="form-control form-control-sm"
                   placeholder="Nhập mã xe (VD: 1)"
                   value="<?= htmlspecialchars($bicycle_id ?: '') ?>" min="1">
            <button type="submit" class="btn btn-sm"
                    style="background:linear-gradient(90deg,#6c5ce7,#5b5ce2);color:white;white-space:nowrap;border-radius:8px">
                <i class="fa fa-search me-1"></i>Xem báo cáo
            </button>
        </form>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger" style="max-width:720px"><?= htmlspecialchars($error) ?></div>

    <?php elseif ($data): ?>

        <?php if (!empty($data['bicycle_info'])): ?>
        <div class="bike-info-card" style="max-width:720px">
            <span style="font-size:32px">🚲</span>
            <div>
                <div style="font-weight:700;font-size:15px;color:#333">
                    <?= htmlspecialchars($data['bicycle_info']['name']) ?>
                    <span class="api-badge">🔗 Từ Bicycle Service</span>
                </div>
                <div style="font-size:12px;color:#888;margin-top:2px">
                    <?= htmlspecialchars($data['bicycle_info']['brand_name'] ?? '') ?>
                    · Size <?= htmlspecialchars($data['bicycle_info']['frame_size'] ?? '') ?>
                    · <?= htmlspecialchars($data['bicycle_info']['condition_status'] ?? '') ?>
                    · <?= number_format($data['bicycle_info']['price'] ?? 0) ?> VNĐ
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div style="max-width:720px">
        <?php if ($data['is_verified']): ?>
            <div class="verified-banner">
                <div class="verified-icon">✅</div>
                <div>
                    <div style="font-size:18px;font-weight:700;color:#065f46">Xe đã được kiểm định</div>
                    <div style="font-size:13px;color:#065f46;opacity:0.8">Xe #<?= $bicycle_id ?> đã được Inspector chứng nhận và Admin phê duyệt.</div>
                </div>
            </div>
        <?php else: ?>
            <div class="not-verified-banner">
                <div class="not-verified-icon">🔍</div>
                <div>
                    <div style="font-weight:700;color:#495057">Chưa có kiểm định được duyệt</div>
                    <div style="font-size:13px;color:#6c757d">
                        Xe #<?= $bicycle_id ?> chưa có báo cáo kiểm định nào được phê duyệt.
                        <?php if ($data['total'] > 0): ?> Có <?= $data['total'] ?> báo cáo đang chờ xét duyệt.<?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        </div>

        <?php if ($data['total'] === 0): ?>
            <div class="text-center text-muted py-5" style="font-size:13px;max-width:720px">
                <i class="fa fa-inbox fa-2x mb-3 d-block" style="color:#ddd"></i>Chưa có báo cáo kiểm định nào cho xe này.
            </div>
        <?php else: ?>
            <p style="font-size:13px;color:#555;max-width:720px" class="mb-3">
                <i class="fa fa-clipboard-list me-1" style="color:#5b5ce2"></i><?= $data['total'] ?> báo cáo kiểm định
            </p>

            <?php foreach ($data['reports'] as $r): ?>
            <?php [$sc, $sbg] = scoreColor((int)$r['overall_score']); ?>
            <div class="report-card" style="max-width:720px">
                <div class="report-card-header">
                    <span>
                        Báo cáo <strong style="color:#5b5ce2">#<?= $r['id'] ?></strong>
                        <?php if (!empty($r['bicycle_name'])): ?> — <?= htmlspecialchars($r['bicycle_name']) ?><?php endif; ?>
                        <span class="text-muted fw-normal ms-1">· Inspector #<?= $r['inspector_id'] ?></span>
                    </span>
                    <span class="status-pill status-<?= $r['status'] ?>">
                        <?= match($r['status']) { 'pending'=>'⏳ Chờ duyệt', 'approved'=>'✅ Đã duyệt', 'rejected'=>'❌ Từ chối', default=>$r['status'] } ?>
                    </span>
                </div>
                <div class="p-4">
                    <div class="d-flex gap-4 align-items-start">
                        <div class="score-circle" style="border-color:<?= $sc ?>;color:<?= $sc ?>">
                            <div class="score-number"><?= $r['overall_score'] ?></div>
                            <div class="score-label">/ 100</div>
                        </div>
                        <div style="flex:1">
                            <div class="check-row"><span>🔧 Khung xe</span><?= conditionBadge($r['frame_condition']) ?></div>
                            <div class="check-row"><span>🛑 Phanh</span><?= conditionBadge($r['brake_condition']) ?></div>
                            <div class="check-row"><span>⚙️ Truyền động</span><?= conditionBadge($r['drivetrain_condition']) ?></div>
                            <div class="check-row"><span>🔵 Lốp xe</span><?= conditionBadge($r['tire_condition']) ?></div>
                        </div>
                    </div>
                    <?php if (!empty($r['notes'])): ?>
                        <div class="mt-3 p-3" style="background:#f8f9ff;border-radius:8px;font-size:13px;">
                            <strong>📝 Ghi chú:</strong> <?= htmlspecialchars($r['notes']) ?>
                        </div>
                    <?php endif; ?>
                    <div class="mt-3 d-flex gap-3" style="font-size:11px;color:#aaa">
                        <span>📅 Kiểm định: <?= date('H:i d/m/Y', strtotime($r['created_at'])) ?></span>
                        <?php if (!empty($r['approved_at'])): ?>
                            <span>✅ Duyệt: <?= date('H:i d/m/Y', strtotime($r['approved_at'])) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ($r['status'] === 'pending'): ?>
                    <div class="mt-3 pt-3" style="border-top:1px solid #f0f0f0">
                        <a href="admin_approve.php" class="btn btn-sm"
                           style="background:linear-gradient(90deg,#6c5ce7,#5b5ce2);color:white;border-radius:8px;font-size:12px">
                            <i class="fa fa-check me-1"></i>Đến trang duyệt báo cáo
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

    <?php elseif ($bicycle_id > 0): ?>
        <div class="alert alert-warning" style="max-width:720px">Không tìm thấy báo cáo cho xe #<?= $bicycle_id ?>.</div>
    <?php endif; ?>

</div>
</body>
</html>