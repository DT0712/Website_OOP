<?php include $_SERVER['DOCUMENT_ROOT'] . "/Website_OOP/Guest/includes/header.php"; ?>

<h2>Tin nhắn</h2>

<?php if (empty($messages)): ?>
    <p>Chưa có tin nhắn nào</p>
<?php else: ?>
    <?php foreach ($messages as $m): ?>
        <div>
            <b>User <?= $m['nguoi_gui_id'] ?>:</b>
            <?= htmlspecialchars($m['noi_dung']) ?>
            <small><?= $m['created_at'] ?></small>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<hr>

<?php if (isset($_GET['id'])): ?>
    <form method="POST" action="index.php?action=send">
        <input type="hidden" name="hoi_thoai_id"
               value="<?= $_GET['id'] ?>">

        <input type="text" name="noi_dung"
               placeholder="Nhập tin nhắn..." required>

        <button type="submit">Gửi</button>
    </form>
<?php else: ?>
    <p style="color:red;">Thiếu ID hội thoại</p>
<?php endif; ?>

<br>
<a href="index.php">← Quay lại</a>

