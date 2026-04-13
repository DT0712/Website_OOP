<?php
include 'config.php';

$sql = "SELECT posts.*, khach_hang.ho_ten, khach_hang.anh_dai_dien
        FROM posts
        JOIN khach_hang 
        ON posts.user_id = khach_hang.id_khach_hang
        ORDER BY posts.created_at DESC";

$result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {

    $reacts = mysqli_query($conn,"
    SELECT type, COUNT(*) as total 
    FROM post_likes 
    WHERE post_id=".$row['id']." 
    GROUP BY type");

    $react_data = [];
    $total_like = 0;

    while($r = mysqli_fetch_assoc($reacts)){
        $react_data[$r['type']] = $r['total'];
        $total_like += $r['total'];
    }
    ?>

    <div class="post-card">

    <!-- HEADER -->
    <div class="post-header">
        <img src="<?= $row['anh_dai_dien'] ?: 'assets/images/avatar.png' ?>" class="avatar">
        <div>
            <b><?= $row['ho_ten'] ?></b><br>
            <small><?= date("d/m/Y H:i", strtotime($row['created_at'])) ?></small>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="post-content">
        <p><?= $row['content'] ?></p>
        <b><?= $row['product_name'] ?></b><br>
        <span style="color:red"><?= number_format($row['price']) ?>đ</span>
        <p>📍 <?= $row['location'] ?></p>
    </div>

    <!-- IMAGE -->
    <?php if(!empty($row['image']) && file_exists($row['image'])) { ?>
    <img src="<?= $row['image'] ?>" class="post-image">
    <?php } ?>

    <!-- ACTION -->
    <div class="post-actions">

    
    <!-- REACTION -->
    <div class="reaction-box"
    onmouseenter="showReact(<?= $row['id'] ?>)"
        onmouseleave="hideReact(<?= $row['id'] ?>)"
    >

        <!-- BUTTON -->
        <button onclick="reactPost(<?= $row['id'] ?>,'like')">
        👍 
        <span onclick="event.stopPropagation(); openReactList(<?= $row['id'] ?>)" 
            id="like-<?= $row['id'] ?>">
            <?= $total_like ?>
        </span>
    </button>

        <!-- REACTION -->
        <div class="reaction-list" id="react-<?= $row['id'] ?>"onclick="event.stopPropagation()"
        onmouseenter="showReact(<?= $row['id'] ?>)"
        onmouseleave="hideReact(<?= $row['id'] ?>)">
            <span onclick="reactPost(<?= $row['id'] ?>,'like'); event.stopPropagation();">👍</span>
            <span onclick="reactPost(<?= $row['id'] ?>,'love'); event.stopPropagation();">❤️</span>
            <span onclick="reactPost(<?= $row['id'] ?>,'haha'); event.stopPropagation();">😂</span>
            <span onclick="reactPost(<?= $row['id'] ?>,'wow'); event.stopPropagation();">😮</span>
            <span onclick="reactPost(<?= $row['id'] ?>,'sad'); event.stopPropagation();">😢</span>
            <span onclick="reactPost(<?= $row['id'] ?>,'angry'); event.stopPropagation();">😡</span>
        </div>

    </div>

    <!-- COMMENT ICON -->
    <button onclick="focusComment(<?= $row['id'] ?>)">💬</button>

    </div>

    <!-- COMMENT -->
    <div class="comment-box">

    <div id="comments-<?= $row['id'] ?>">
    <?php
    $cmt = mysqli_query($conn,"
    SELECT comments.*, khach_hang.ho_ten, khach_hang.anh_dai_dien
    FROM comments
    JOIN khach_hang 
    ON comments.user_id = khach_hang.id_khach_hang
    WHERE comments.post_id=".$row['id']);

    while($c=mysqli_fetch_assoc($cmt)){
    ?>
    <div class="comment-item">
        <img src="<?= $c['anh_dai_dien'] ?: 'assets/images/avatar.png' ?>" class="avatar" style="width:30px;height:30px;">
        <div class="comment-bubble">
            <b><?= $c['ho_ten'] ?></b><br>
            <?= $c['content'] ?>
        </div>
    </div>
    <?php } ?>
    </div>

    <input id="cmt-<?= $row['id'] ?>"
        type="text"
        placeholder="Viết bình luận..."
        onkeypress="submitComment(event, <?= $row['id'] ?>)">

    </div>

    </div>


    <?php } ?>