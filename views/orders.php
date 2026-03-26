<!DOCTYPE html>
<html>
<head>
    <title>Buyer Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .card-custom {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .table img {
            border-radius: 8px;
        }

        .cancelled-row {
            opacity: 0.6;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card card-custom p-4 mb-5">
        <h4 class="mb-3">🛒 Đơn mua của tôi</h4>

    <table class="table align-middle">
        <thead class="table-light">
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
            'pending' => 'bg-secondary',
            'accepted' => 'bg-primary',
            'rejected' => 'bg-dark',
            'deposit_paid' => 'bg-warning',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger'
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
                    <span class="badge <?= $statusClass[$o['status']] ?>">
                        <?= $statusText[$o['status']] ?>
                    </span>
                </td>

                <td>
                    <?php if($o['status'] == 'accepted'): ?>
                        <button class="btn btn-warning btn-sm"
                            onclick="openDepositModal(<?= $o['id'] ?>, <?= $o['price'] ?>)">
                            Đặt cọc
                        </button>
                    <?php endif; ?>

                    <?php if(!in_array($o['status'], ['completed', 'cancelled'])): ?>
                        <a href="?action=cancel&id=<?= $o['id'] ?>"
                            class="btn btn-danger btn-sm"
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

    <div class="card card-custom p-4" style="margin-bottom: 50px;">
        <h4 class="mb-3">🏷️ Brand đã mua</h4>

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 50%">Brand</th>
                    <th style="width: 50%">Số lần mua</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($brands)): ?>
                <?php foreach($brands as $b): ?>
                    <tr>
                        <td><strong><?= $b['name'] ?></strong></td>
                        <td>
                            <span class="badge bg-success">
                                <?= $b['total'] ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        Chưa có dữ liệu
                    </td>
                </tr>
            <?php endif; ?>
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