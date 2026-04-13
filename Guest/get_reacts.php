<?php
include 'config.php';

$post_id = $_GET['post_id'];

$sql = "
SELECT khach_hang.ho_ten, khach_hang.anh_dai_dien, post_likes.type
FROM post_likes
JOIN khach_hang 
ON post_likes.user_id = khach_hang.id_khach_hang
WHERE post_likes.post_id = $post_id
";

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)){
?>
<div class="react-user">
    <img src="<?= $row['anh_dai_dien'] ?: 'assets/images/avatar.png' ?>">
    <b><?= $row['ho_ten'] ?></b>
    <span style="margin-left:auto">
        <?= match($row['type']){
            'like'=>"👍",
            'love'=>"❤️",
            'haha'=>"😂",
            'wow'=>"😮",
            'sad'=>"😢",
            'angry'=>"😡"
        } ?>
    </span>
</div>
<?php } ?>