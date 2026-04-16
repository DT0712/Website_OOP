<?php
session_start();
include 'config.php';

$user_id = $_SESSION['khach_hang']['id_khach_hang'];
$post_id = $_POST['post_id'];
$content = mysqli_real_escape_string($conn, $_POST['content']);

mysqli_query($conn,"
INSERT INTO comments(post_id,user_id,content)
VALUES($post_id,$user_id,'$content')");

$cmt = mysqli_query($conn,"
SELECT comments.*, khach_hang.ho_ten, khach_hang.anh_dai_dien
FROM comments
JOIN khach_hang 
ON comments.user_id = khach_hang.id_khach_hang
WHERE comments.post_id=$post_id");

while($c=mysqli_fetch_assoc($c)){
?>
<div class="comment-item">
    <img src="<?= $c['anh_dai_dien'] ?: 'assets/images/avatar.png' ?>" class="avatar" style="width:30px;height:30px;">
    <div class="comment-bubble">
        <b><?= $c['ho_ten'] ?></b><br>
        <?= $c['content'] ?>
    </div>
</div>
<?php } ?>