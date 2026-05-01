<?php
$current_page = basename($_SERVER['PHP_SELF']);
$API_BASE = "http://localhost/Website_OOP/Inspection-Service/public/index.php";

if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION['user_id']   = 99;
$_SESSION['user_role'] = 'admin';

function callAPI(string $method, string $url, array $data = []): ?array {
    $opts = [
        'http' => [
            'method'        => strtoupper($method),
            'header'        => "Content-Type: application/json\r\n" .
                               "X-User-Id: "   . ($_SESSION['user_id']   ?? 99)      . "\r\n" .
                               "X-User-Role: " . ($_SESSION['user_role'] ?? 'admin') . "\r\n",
            'content'       => $method !== 'GET' ? json_encode($data) : null,
            'timeout'       => 5,
            'ignore_errors' => true,
        ]
    ];
    $resp = @file_get_contents($url, false, stream_context_create($opts));
    return $resp ? json_decode($resp, true) : null;
}

$message  = null;
$msg_type = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action    = $_POST['action']    ?? '';
    $report_id = (int)($_POST['report_id'] ?? 0);

    if ($action === 'approve' && $report_id > 0) {
        $result = callAPI('PUT', $API_BASE . '/inspection/approve', ['report_id' => $report_id]);
        if ($result['success'] ?? false) {
            $message = "✅ Đã duyệt báo cáo #$report_id — Xe được gắn nhãn Verified!";
        } else {
            $message  = "❌ " . ($result['message'] ?? 'Lỗi không xác định');
            $msg_type = 'danger';
        }
    } elseif ($action === 'reject' && $report_id > 0) {
        $result = callAPI('PUT', $API_BASE . '/inspection/reject', ['report_id' => $report_id]);
        if ($result['success'] ?? false) {
            $message = "🚫 Đã từ chối báo cáo #$report_id.";
        } else {
            $message  = "❌ " . ($result['message'] ?? 'Lỗi không xác định');
            $msg_type = 'warning';
        }
    }
}

$filter   = $_GET['filter'] ?? 'all';
$response = callAPI('GET', $API_BASE . '/inspection/reports?filter=' . urlencode($filter));

$reports        = $response['data']['reports'] ?? [];
$total_pending  = $response['data']['stats']['pending']  ?? 0;
$total_approved = $response['data']['stats']['approved'] ?? 0;
$total_rejected = $response['data']['stats']['rejected'] ?? 0;

function conditionBadge(string $cond): string {
    return match($cond) {
        'good'  => '<span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill" style="font-size:11px">Tốt</span>',
        'fair'  => '<span class="badge bg-warning-subtle text-warning px-2 py-1 rounded-pill" style="font-size:11px">TB</span>',
        'poor'  => '<span class="badge bg-danger-subtle text-danger px-2 py-1 rounded-pill" style="font-size:11px">Kém</span>',
        default => '—',
    };
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Kiểm Định Xe — Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
body { background: #f5f7fb; display: flex; }
.stat-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 16px; }
.stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
.stat-number { font-size: 26px; font-weight: bold; line-height: 1; }
.stat-label  { font-size: 12px; color: #888; margin-top: 2px; }
.filter-tabs { display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; }
.filter-tab { padding: 6px 16px; border-radius: 20px; border: 1px solid #ddd; background: white; font-size: 13px; text-decoration: none; color: #555; transition: 0.2s; }
.filter-tab:hover  { border-color: #5b5ce2; color: #5b5ce2; }
.filter-tab.active { background: linear-gradient(90deg,#6c5ce7,#5b5ce2); border-color: transparent; color: white; }
.card-box { border-radius: 12px; background: white; box-shadow: 0 2px 6px rgba(0,0,0,0.05); overflow: hidden; }
.card-box-header { padding: 16px 20px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; font-weight: 600; font-size: 14px; color: #333; }
.table { margin: 0; font-size: 13px; }
.table th { background: #f8f9ff; padding: 12px 16px; font-weight: 600; color: #555; border-bottom: 1px solid #eee; white-space: nowrap; }
.table td { padding: 12px 16px; vertical-align: middle; border-bottom: 1px solid #f5f5f5; }
.table tr:last-child td { border-bottom: none; }
.table tr:hover td { background: #fafbff; }
.score-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-weight: bold; font-size: 12px; }
.status-pill { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap; }
.status-pending  { background: #fff3cd; color: #856404; }
.status-approved { background: #d1fae5; color: #065f46; }
.status-rejected { background: #fee2e2; color: #991b1b; }
.btn-approve { background: #d1fae5; color: #065f46; border: none; border-radius: 8px; padding: 5px 14px; font-size: 12px; font-weight: 600; cursor: pointer; transition: 0.2s; }
.btn-approve:hover { background: #a7f3d0; }
.btn-reject  { background: #fee2e2; color: #991b1b; border: none; border-radius: 8px; padding: 5px 14px; font-size: 12px; font-weight: 600; cursor: pointer; transition: 0.2s; }
.btn-reject:hover  { background: #fecaca; }
.section-divider { border-bottom: 1px solid #e1d9d9; margin: 15px 0; }
.action-buttons { display: flex; align-items: center; gap: 6px; flex-wrap: nowrap; }
.action-buttons form { margin: 0; display: flex; }
.btn-approve, .btn-reject {
    white-space: nowrap;
    min-width: 70px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}
.sidebar {
    width: 250px;
    background: white;
    height: 100vh;
    padding: 20px;
    box-shadow: 0 0 20px rgba(0,0,0,.05);
    position: fixed;
    top: 0; left: 0;
    overflow-y: auto;
}
.logo {
    font-size: 22px;
    font-weight: 700;
    color: #5b5ce2;
    margin-bottom: 30px;
}
.menu a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 8px;
    text-decoration: none;
    color: #555;
    font-size: 14px;
    transition: 0.2s;
}
.menu a.active,
.menu a:hover {
    background: linear-gradient(90deg, #6c5ce7, #5b5ce2);
    color: white;
}
.main {
    margin-left: 260px;
    padding: 28px;
    flex: 1;
}
</style>
</head>
<body>

<?php include __DIR__ . "/sidebar.php"; ?>

<div class="main" style="margin-left:270px; padding:28px 32px; flex:1;">
    <h3 class="mb-1">🔍 Quản Lý Kiểm Định Xe</h3>
    <p class="text-muted mb-3" style="font-size:13px;">
        Duyệt báo cáo kiểm định để gắn nhãn ✅ Verified cho xe
        <span class="badge rounded-pill ms-2" style="background:#e8e8ff;color:#5b5ce2;font-size:11px;">Inspection Service API</span>
    </p>
    <div class="section-divider"></div>

    <?php if ($message): ?>
        <div class="alert alert-<?= $msg_type ?> alert-dismissible py-2" style="font-size:13px;">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fff8e1;">⏳</div>
                <div><div class="stat-number" style="color:#f59e0b;"><?= $total_pending ?></div><div class="stat-label">Chờ duyệt</div></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#d1fae5;">✅</div>
                <div><div class="stat-number" style="color:#059669;"><?= $total_approved ?></div><div class="stat-label">Đã duyệt</div></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fee2e2;">❌</div>
                <div><div class="stat-number" style="color:#dc2626;"><?= $total_rejected ?></div><div class="stat-label">Đã từ chối</div></div>
            </div>
        </div>
    </div>

    <div class="filter-tabs">
        <a href="?filter=all"      class="filter-tab <?= $filter==='all'      ?'active':''?>">Tất cả (<?= $total_pending+$total_approved+$total_rejected ?>)</a>
        <a href="?filter=pending"  class="filter-tab <?= $filter==='pending'  ?'active':''?>">⏳ Chờ duyệt (<?= $total_pending ?>)</a>
        <a href="?filter=approved" class="filter-tab <?= $filter==='approved' ?'active':''?>">✅ Đã duyệt (<?= $total_approved ?>)</a>
        <a href="?filter=rejected" class="filter-tab <?= $filter==='rejected' ?'active':''?>">❌ Từ chối (<?= $total_rejected ?>)</a>
    </div>

    <div class="card-box">
        <div class="card-box-header">
            <span><i class="fa fa-clipboard-list me-2" style="color:#5b5ce2"></i>Danh sách báo cáo kiểm định</span>
            <span class="text-muted" style="font-size:12px;"><?= count($reports) ?> báo cáo</span>
        </div>
        <?php if (empty($reports)): ?>
            <div class="text-center text-muted p-5" style="font-size:13px;">
                <i class="fa fa-inbox fa-2x mb-3 d-block" style="color:#ddd"></i>Không có báo cáo nào.
            </div>
        <?php else: ?>
        <div style="overflow-x:auto;">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#ID</th><th>Xe</th><th>Inspector</th>
                    <th>Khung</th><th>Phanh</th><th>Truyền động</th><th>Lốp</th>
                    <th>Điểm</th><th>Trạng thái</th><th>Ngày tạo</th><th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $r): ?>
                <?php
                    $score      = (int)$r['overall_score'];
                    $sc         = $score>=80 ? '#059669' : ($score>=50 ? '#d97706' : '#dc2626');
                    $sbg        = $score>=80 ? '#d1fae5' : ($score>=50 ? '#fef3c7' : '#fee2e2');
                    $bike_label = !empty($r['bicycle_name']) ? $r['bicycle_name'] : "Xe #{$r['bicycle_id']}";
                ?>
                <tr>
                    <td><strong style="color:#5b5ce2">#<?= $r['id'] ?></strong></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <span style="font-size:18px">🚲</span>
                            <div>
                                <div style="font-weight:600;font-size:13px"><?= htmlspecialchars($bike_label) ?></div>
                                <div style="font-size:11px;color:#aaa">#<?= $r['bicycle_id'] ?></div>
                            </div>
                        </div>
                    </td>
                    <td><span style="font-size:16px">👤</span> #<?= $r['inspector_id'] ?></td>
                    <td><?= conditionBadge($r['frame_condition']) ?></td>
                    <td><?= conditionBadge($r['brake_condition']) ?></td>
                    <td><?= conditionBadge($r['drivetrain_condition']) ?></td>
                    <td><?= conditionBadge($r['tire_condition']) ?></td>
                    <td>
                        <span class="score-badge" style="background:<?= $sbg ?>;color:<?= $sc ?>">
                            <?= $score ?>/100
                        </span>
                    </td>
                    <td>
                        <span class="status-pill status-<?= $r['status'] ?>">
                            <?= match($r['status']) {
                                'pending'  => '⏳ Chờ duyệt',
                                'approved' => '✅ Đã duyệt',
                                'rejected' => '❌ Từ chối',
                                default    => $r['status']
                            } ?>
                        </span>
                    </td>
                    <td style="font-size:11px;color:#aaa;white-space:nowrap"><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
                    <td>
                        <?php if ($r['status'] === 'pending'): ?>
                        <div class="action-buttons">
                            <form method="POST">
                                <input type="hidden" name="action" value="approve">
                                <input type="hidden" name="report_id" value="<?= $r['id'] ?>">
                                <button type="submit" class="btn-approve" onclick="return confirm('Duyệt báo cáo #<?= $r['id'] ?>?')">✅ Duyệt</button>
                            </form>
                            <form method="POST">
                                <input type="hidden" name="action" value="reject">
                                <input type="hidden" name="report_id" value="<?= $r['id'] ?>">
                                <button type="submit" class="btn-reject" onclick="return confirm('Từ chối báo cáo #<?= $r['id'] ?>?')">❌ Từ chối</button>
                            </form>
                        </div>
                        <?php else: ?>
                            <a href="report_detail.php?bicycle_id=<?= $r['bicycle_id'] ?>" style="font-size:12px;color:#5b5ce2;text-decoration:none;">Xem →</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>