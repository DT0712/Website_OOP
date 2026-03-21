<!DOCTYPE html>
<html>
<head>
    <title>Buyer Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a href="?action=deposit&id=<?= $o['id'] ?>" class="btn btn-warning btn-sm">Đặt cọc</a>
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

</body>
</html>