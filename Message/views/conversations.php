<?php include $_SERVER['DOCUMENT_ROOT'] . "/Website_OOP/Guest/includes/header.php"; ?>

<h2>Danh sách hội thoại</h2>

<?php if (empty($conversations)): ?>
    <p>Chưa có tin nhắn nào.</p>
<?php else: ?>
    <?php foreach ($conversations as $c): ?>
        <div>
            <a href="index.php?action=chat&id=<?= $c['id'] ?>">
                Hội thoại #<?= $c['id'] ?>
                — Xe ID: <?= $c['xe_id'] ?>
                — <?= $c['tin_nhan_cuoi'] ?? 'Chưa có tin nhắn' ?>
            </a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

