<!DOCTYPE html>
<html>
<head>
    <title>Buyer Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/buyer-order-module/assets/css/style.css?v=<?= time() ?>">
</head>
<body>

<div class="container mt-5">
    <div class="card card-custom p-4 mb-5">
        <h4 class="mb-3">🛒 Đơn mua của tôi</h4>

    <table class="table align-middle">
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Xe</th>
                <th>Giá</th>
                <th>Cọc</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
        <?php
        $statusClass = [
            'pending' => 'badge-pending',
            'accepted' => 'badge-accepted',
            'rejected' => 'badge-rejected',
            'deposit_paid' => 'badge-deposit_paid',
            'completed' => 'badge-completed',
            'cancelled' => 'badge-cancelled'
        ];

        $statusText = [
            'pending' => 'Chờ xác nhận',
            'accepted' => 'Đã chấp nhận',
            'rejected' => 'Bị từ chối',
            'deposit_paid' => 'Đã đặt cọc',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy'
        ];
        ?>
        <?php foreach($orders as $o): ?>
            <tr class="<?= $o['status'] == 'cancelled' ? 'cancelled-row' : '' ?>">
                <td>
                    <img src="/buyer-order-module/<?= $o['main_image'] ?>" 
                        width="80" height="60"
                        style="object-fit: cover; border-radius: 5px;"
                        onerror="this.src='https://via.placeholder.com/80x60'" >
                </td>
                <td><?= $o['name'] ?></td>
                <td><?= number_format($o['price']) ?></td>
                <td><?= number_format($o['deposit_amount']) ?></td>

                <td>
                    <span class="btn-soft <?= $statusClass[$o['status']] ?>">
                        <?= $statusText[$o['status']] ?>
                    </span>
                </td>

                <td>
                    <?php if($o['status'] == 'accepted'): ?>
                        <button class="btn btn-soft btn-deposit"
                            onclick="openDepositModal(<?= $o['id'] ?>, <?= $o['price'] ?>)">
                            Đặt cọc
                        </button>
                    <?php endif; ?>

                    <?php if(!in_array($o['status'], ['completed', 'cancelled'])): ?>
                        <a href="?action=cancel&id=<?= $o['id'] ?>"
                            class="btn btn-soft btn-cancel"
                            onclick="return confirm('Bạn có chắc muốn hủy đơn này không?')">
                            Hủy
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <div class="card card-custom p-4" style="margin-bottom: 50px; margin-right: 370px">
        <h4 class="mb-3">🏷️ Brand đã mua</h4>

        <table class="table table-hover align-middle">
            <tbody>
            <?php
            // tìm max để tính %
            $max = 0;
            foreach ($brands as $b) {
                if ($b['total'] > $max) $max = $b['total'];
            }
            ?>

            <?php foreach($brands as $b): 
                $percent = ($max > 0) ? ($b['total'] / $max) * 100 : 0;
                if ($percent <= 20) {
                    $color = '#f44336';
                } elseif ($percent <= 40) {
                    $color = '#ff9800';
                } elseif ($percent <= 60) {
                    $color = '#ffc107';
                } elseif ($percent <= 80) {
                    $color = '#2196f3';
                } else {
                    $color = '#4caf50';
                }
            ?>
            <tr>
                <td><strong><?= $b['name'] ?></strong></td>
                <td style="width: 40%;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        
                        <span style="font-size: 13px; font-weight: 600; min-width: 40px;">
                            <?= round($percent) ?>%
                        </span>

                        <div class="progress" style="width: 50%">
                            <div class="progress-bar" style="width: <?= $percent ?>%; background: <?= $color ?>;"></div>
                        </div>

                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="depositModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="GET" action="index.php">
        <input type="hidden" name="action" value="deposit">
        <input type="hidden" name="id" id="order_id">

        <div class="modal-content">
            <div class="modal-header">
                <h5>Nhập số tiền đặt cọc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="number" name="amount" id="deposit_input" class="form-control"
                       placeholder="Nhập số tiền cọc..." required>

                <small id="suggest_text" class="text-muted"></small>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Xác nhận</button>
            </div>
        </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function openDepositModal(id, price) {
    document.getElementById("order_id").value = id;

    let minDeposit = Math.max(price * 0.2, 500000);

    document.getElementById("deposit_input").value = minDeposit;
    document.getElementById("deposit_input").min = minDeposit;

    document.getElementById("suggest_text").innerText =
        "Cọc tối thiểu: " + minDeposit.toLocaleString() + " VNĐ";

    var modal = new bootstrap.Modal(document.getElementById('depositModal'));
    modal.show();
}
</script>

</body>
</html>