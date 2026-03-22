<!DOCTYPE html>
<html>
<head>
    <title>Buyer Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2>🛒 Đơn mua của tôi</h2>

    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Xe</th>
                <th>Giá</th>
                <th>Cọc</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
        <?php foreach($orders as $o): ?>
            <tr>
                <td><?= $o['id'] ?></td>
                <td><?= $o['name'] ?></td>
                <td><?= number_format($o['price']) ?></td>
                <td><?= number_format($o['deposit_amount']) ?></td>

                <td>
                    <span class="badge bg-info"><?= $o['status'] ?></span>
                </td>

                <td>
                    <?php if($o['status'] == 'accepted'): ?>
                        <button class="btn btn-warning btn-sm"
                            onclick="openDepositModal(<?= $o['id'] ?>, <?= $o['price'] ?>)">
                            Đặt cọc
                        </button>
                    <?php endif; ?>

                    <?php if($o['status'] != 'completed'): ?>
                        <a href="?action=cancel&id=<?= $o['id'] ?>" class="btn btn-danger btn-sm">Hủy</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
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