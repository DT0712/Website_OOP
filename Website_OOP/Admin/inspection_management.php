<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/../../InspectionService/app/config/database.php";

if (session_status() === PHP_SESSION_NONE) session_start();
$current_page = basename($_SERVER['PHP_SELF']);

// Load thống kê từ db_inspection
$db   = new Database();
$conn = $db->connect();

$counts = $conn->query(
    "SELECT status, COUNT(*) as cnt FROM inspection_reports GROUP BY status"
)->fetchAll(PDO::FETCH_KEY_PAIR);

$total_pending  = $counts['pending']  ?? 0;
$total_approved = $counts['approved'] ?? 0;
$total_rejected = $counts['rejected'] ?? 0;
$total_all      = $total_pending + $total_approved + $total_rejected;

// 5 báo cáo mới nhất
$recent = $conn->query(
    "SELECT * FROM inspection_reports ORDER BY created_at DESC LIMIT 5"
)->fetchAll();
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
* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
body { background: #f5f7fb; display: flex; }

/* ── Sidebar ── */
.sidebar {
    width: 250px; background: white; height: 100vh;
    padding: 20px; box-shadow: 0 0 20px rgba(0,0,0,.05);
    position: fixed; top: 0; left: 0; overflow-y: auto;
}
.logo { font-size: 22px; font-weight: 700; color: #5b5ce2; margin-bottom: 30px; }
.menu a {
    display: flex; align-items: center; gap: 10px;
    padding: 12px; border-radius: 10px; margin-bottom: 8px;
    text-decoration: none; color: #555; font-size: 14px; transition: 0.2s;
}
.menu a.active, .menu a:hover {
    background: linear-gradient(90deg,#6c5ce7,#5b5ce2); color: white;
}

/* ── Main ── */
.main { margin-left: 260px; padding: 28px; flex: 1; }

/* ── Stat cards ── */
.stat-card {
    background: white; border-radius: 14px; padding: 22px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    display: flex; align-items: center; gap: 16px;
    transition: 0.2s; cursor: pointer; text-decoration: none; color: inherit;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.1); }
.stat-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;
}
.stat-number { font-size: 28px; font-weight: 700; line-height: 1; }
.stat-label  { font-size: 12px; color: #888; margin-top: 3px; }

/* ── Quick action cards ── */
.action-card {
    background: white; border-radius: 14px; padding: 24px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    text-decoration: none; color: inherit; display: block;
    transition: 0.2s; border: 2px solid transparent;
}
.action-card:hover { border-color: #5b5ce2; transform: translateY(-2px); color: inherit; }
.action-card-icon {
    width: 56px; height: 56px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; margin-bottom: 14px;
}
.action-card-title { font-weight: 700; font-size: 15px; margin-bottom: 6px; }
.action-card-desc  { font-size: 12px; color: #888; line-height: 1.5; }

/* ── Recent table ── */
.card-box {
    background: white; border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06); overflow: hidden;
}
.card-box-header {
    padding: 16px 20px; border-bottom: 1px solid #f0f0f0;
    display: flex; justify-content: space-between; align-items: center;
}
.card-box-header h6 { margin: 0; font-weight: 700; font-size: 14px; color: #333; }
.table { margin: 0; font-size: 13px; }
.table th {
    background: #f8f9ff; padding: 12px 16px;
    font-weight: 600; color: #555; border-bottom: 1px solid #eee;
}
.table td { padding: 12px 16px; vertical-align: middle; border-bottom: 1px solid #f5f5f5; }
.table tr:last-child td { border-bottom: none; }
.table tr:hover td { background: #fafbff; }

.status-pill { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.status-pending  { background: #fef3c7; color: #92400e; }
.status-approved { background: #d1fae5; color: #065f46; }
.status-rejected { background: #fee2e2; color: #991b1b; }

.api-badge {
    display: inline-block; background: #e8e8ff; color: #5b5ce2;
    border: 1px solid #c4c4f0; border-radius: 20px;
    padding: 2px 10px; font-size: 11px;
}
.section-divider { border-bottom: 1px solid #eee; margin: 20px 0; }
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo">
        VENUS<br>
        <small style="font-size:12px;color:#999">DASHBOARD</small>
    </div>
    <div class="menu">
        <a href="dashboard.php" class="<?= $current_page==='dashboard.php' ? 'active':'' ?>">
            <i class="fa fa-chart-line"></i> Dashboard
        </a>
        <a href="user_management.php" class="<?= $current_page==='user_management.php' ? 'active':'' ?>">
            <i class="fa fa-users"></i> Quản lý người dùng
        </a>
        <a href="bicycle_management.php" class="<?= $current_page==='bicycle_management.php' ? 'active':'' ?>">
            <i class="fa fa-bicycle"></i> Quản lý xe đạp
        </a>
        <a href="inspection_management.php" class="<?= $current_page==='inspection_management.php' ? 'active':'' ?>">
            <i class="fa fa-check-circle"></i> Kiểm định xe
        </a>
        <a href="transaction_management.php" class="<?= $current_page==='transaction_management.php' ? 'active':'' ?>">
            <i class="fa fa-credit-card"></i> Giao dịch
        </a>
        <a href="message_management.php" class="<?= $current_page==='message_management.php' ? 'active':'' ?>">
            <i class="fa fa-envelope"></i> Tin nhắn
        </a>
        <a href="system_statistics.php" class="<?= $current_page==='system_statistics.php' ? 'active':'' ?>">
            <i class="fa fa-chart-bar"></i> Thống kê
        </a>
    </div>
</div>

<!-- MAIN -->
<div class="main">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <h4 class="mb-0">🔍 Kiểm Định Xe Đạp</h4>
            <p class="text-muted mb-0" style="font-size:13px;">
                Quản lý báo cáo kiểm định — đảm bảo minh bạch giao dịch
            </p>
        </div>
        <span class="api-badge">
            <i class="fa fa-plug me-1"></i>Inspection Service API
        </span>
    </div>

    <div class="section-divider"></div>

    <!-- Stat cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <a href="admin_approve.php?filter=all" class="stat-card">
                <div class="stat-icon" style="background:#eef2ff;">📋</div>
                <div>
                    <div class="stat-number" style="color:#5b5ce2;"><?= $total_all ?></div>
                    <div class="stat-label">Tổng báo cáo</div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="admin_approve.php?filter=pending" class="stat-card">
                <div class="stat-icon" style="background:#fef3c7;">⏳</div>
                <div>
                    <div class="stat-number" style="color:#d97706;"><?= $total_pending ?></div>
                    <div class="stat-label">Chờ duyệt</div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="admin_approve.php?filter=approved" class="stat-card">
                <div class="stat-icon" style="background:#d1fae5;">✅</div>
                <div>
                    <div class="stat-number" style="color:#059669;"><?= $total_approved ?></div>
                    <div class="stat-label">Đã duyệt</div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="admin_approve.php?filter=rejected" class="stat-card">
                <div class="stat-icon" style="background:#fee2e2;">❌</div>
                <div>
                    <div class="stat-number" style="color:#dc2626;"><?= $total_rejected ?></div>
                    <div class="stat-label">Đã từ chối</div>
                </div>
            </a>
        </div>
    </div>

    <!-- Quick actions -->
    <h6 class="mb-3" style="color:#555;font-size:13px;font-weight:600;">
        ⚡ Thao tác nhanh
    </h6>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="admin_approve.php" class="action-card">
                <div class="action-card-icon" style="background:#eef2ff;">
                    🛡️
                </div>
                <div class="action-card-title">Duyệt Báo Cáo</div>
                <div class="action-card-desc">
                    Xem danh sách báo cáo đang chờ duyệt và phê duyệt để gắn nhãn Verified cho xe.
                    <?php if ($total_pending > 0): ?>
                        <br><span style="color:#d97706;font-weight:600;margin-top:4px;display:block">
                            ⏳ <?= $total_pending ?> báo cáo đang chờ
                        </span>
                    <?php endif; ?>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="inspector_form.php" class="action-card">
                <div class="action-card-icon" style="background:#d1fae5;">
                    📋
                </div>
                <div class="action-card-title">Tạo Báo Cáo Kiểm Định</div>
                <div class="action-card-desc">
                    Inspector điền checklist kỹ thuật: khung xe, phanh, truyền động, lốp xe và điểm tổng thể.
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="report_detail.php" class="action-card">
                <div class="action-card-icon" style="background:#fef3c7;">
                    🔍
                </div>
                <div class="action-card-title">Xem Báo Cáo Theo Xe</div>
                <div class="action-card-desc">
                    Tra cứu báo cáo kiểm định của một chiếc xe cụ thể theo mã xe (Bicycle ID).
                </div>
            </a>
        </div>
    </div>

    <!-- Báo cáo mới nhất -->
    <div class="card-box">
        <div class="card-box-header">
            <h6><i class="fa fa-clock me-2" style="color:#5b5ce2"></i>Báo cáo kiểm định mới nhất</h6>
            <a href="admin_approve.php" style="font-size:13px;color:#5b5ce2;text-decoration:none;">
                Xem tất cả →
            </a>
        </div>

        <?php if (empty($recent)): ?>
            <div class="text-center text-muted p-5" style="font-size:13px;">
                <i class="fa fa-inbox fa-2x mb-3 d-block" style="color:#ddd"></i>
                Chưa có báo cáo kiểm định nào.
                <br>
                <a href="inspector_form.php" class="btn btn-sm mt-3"
                   style="background:linear-gradient(90deg,#6c5ce7,#5b5ce2);color:white;border-radius:8px">
                    + Tạo báo cáo đầu tiên
                </a>
            </div>
        <?php else: ?>
        <div style="overflow-x:auto">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Xe</th>
                    <th>Inspector</th>
                    <th>Điểm</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent as $r): ?>
                <?php
                    $score    = (int)$r['overall_score'];
                    $sc       = $score >= 80 ? '#059669' : ($score >= 50 ? '#d97706' : '#dc2626');
                    $sbg      = $score >= 80 ? '#d1fae5' : ($score >= 50 ? '#fef3c7' : '#fee2e2');
                    $bike_lbl = !empty($r['bicycle_name']) ? $r['bicycle_name'] : "Xe #{$r['bicycle_id']}";
                ?>
                <tr>
                    <td><strong style="color:#5b5ce2">#<?= $r['id'] ?></strong></td>
                    <td>
                        <div style="font-weight:600;font-size:13px">🚲 <?= htmlspecialchars($bike_lbl) ?></div>
                        <div style="font-size:11px;color:#aaa">#<?= $r['bicycle_id'] ?></div>
                    </td>
                    <td style="color:#555">👤 #<?= $r['inspector_id'] ?></td>
                    <td>
                        <span style="background:<?= $sbg ?>;color:<?= $sc ?>;
                              padding:3px 10px;border-radius:20px;font-weight:700;font-size:12px">
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
                    <td style="font-size:11px;color:#aaa;white-space:nowrap">
                        <?= date('d/m/Y H:i', strtotime($r['created_at'])) ?>
                    </td>
                    <td>
                        <?php if ($r['status'] === 'pending'): ?>
                            <a href="admin_approve.php?filter=pending"
                               style="font-size:12px;color:#d97706;text-decoration:none;font-weight:600">
                                Duyệt →
                            </a>
                        <?php else: ?>
                            <a href="report_detail.php?bicycle_id=<?= $r['bicycle_id'] ?>"
                               style="font-size:12px;color:#5b5ce2;text-decoration:none">
                                Xem →
                            </a>
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