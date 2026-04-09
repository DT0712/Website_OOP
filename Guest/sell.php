<?php
session_start();
include 'config.php';
include 'includes/header.php';

if (!isset($_SESSION['khach_hang'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['khach_hang'];
?>

<style>
body { background:#f0f2f5; font-family:Arial; }
.fb-container { width:550px; margin:30px auto; }

/* CREATE */
.create-post {
    background:#fff; padding:12px;
    border-radius:12px; margin-bottom:20px;
}
.post-top { display:flex; gap:10px; }
.post-top input {
    flex:1; border:none;
    background:#f0f2f5;
    border-radius:20px;
    padding:10px;
}

/* FORM */
.post-form {
    display:none;
    background:#fff;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
}
.post-form input, .post-form textarea {
    width:100%; margin-bottom:10px; padding:10px;
}

/* POST */
.post-card {
    background:#fff;
    border-radius:12px;
    margin-bottom:20px;
}
.post-header { display:flex; gap:10px; padding:12px; }
.avatar { width:40px; height:40px; border-radius:50%; }
.post-content { padding:0 12px 10px; }
.post-image { width:100%; max-height:400px; object-fit:cover; }

/* ACTION */
.post-actions {
    display:flex;
    justify-content:flex-start; 
    gap:20px; 
    border-top:1px solid #ddd;
    padding:8px 12px;
}
/* REACTION */
.reaction-box {
    position: relative;
}

/* Ẩn mặc định */
.reaction-list {
    position: absolute;
    bottom: 100%;
    margin-bottom: 5px; 
    left: 0;

    background: #fff;
    padding: 6px 10px;
    border-radius: 30px;

    display: flex;
    gap: 8px;

    opacity: 0;
    pointer-events: none;

    transition: opacity 0.2s ease, transform 0.2s;
    transform: translateY(10px);
}

/* 👉 KEY FIX: hover cả BOX */

.reaction-list span {
    font-size:22px;
    margin:5px;
    cursor:pointer;
}
.reaction-list span:hover { transform:scale(1.4); }

/* COMMENT */
.comment-box { padding:10px; }
.comment-item { display:flex; gap:8px; margin-bottom:8px; }
.comment-bubble {
    background:#f0f2f5;
    padding:6px 10px;
    border-radius:15px;
}
.comment-box input {
    width:100%;
    padding:8px;
    border-radius:20px;
    border:1px solid #ddd;
}

.post-actions button {
    border: none;
    background: transparent;
    cursor: pointer;
    outline: none;
    box-shadow: none;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 5px;
}
</style>

<div class="fb-container">

<!-- CREATE -->
<div class="create-post">
    <div class="post-top">
        <img src="<?= $user['anh_dai_dien'] ?: 'assets/images/avatar.png' ?>" class="avatar">
        <input type="text" placeholder="Bạn đang nghĩ gì?" onclick="toggleForm()">
    </div>
</div>

<!-- FORM -->
<div class="post-form" id="postForm">
<form action="handle_sell.php" method="POST" enctype="multipart/form-data">
    <textarea name="description" placeholder="Mô tả..."></textarea>
    <input type="text" name="name" placeholder="Tên sản phẩm" required>
    <input type="number" name="price" placeholder="Giá" required>
    <input type="text" name="location" placeholder="Địa điểm">
    <input type="file" name="main_image">
    <button>Đăng bài</button>
</form>
</div>

<?php
$sql = "SELECT posts.*, khach_hang.ho_ten, khach_hang.anh_dai_dien
        FROM posts
        JOIN khach_hang 
        ON posts.user_id = khach_hang.id_khach_hang
        ORDER BY posts.created_at DESC";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {

$like_count = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM post_likes WHERE post_id=".$row['id']))['total'];
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
        👍 <span id="like-<?= $row['id'] ?>"><?= $like_count ?></span>
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

</div>

<script>

let hideTimeout;

function showReact(id){
    clearTimeout(hideTimeout);
    let el = document.getElementById("react-"+id);
    el.style.opacity = "1";
    el.style.pointerEvents = "auto";
    el.style.transform = "translateY(0)";
}

function hideReact(id){
    hideTimeout = setTimeout(()=>{
        let el = document.getElementById("react-"+id);
        el.style.opacity = "0";
        el.style.pointerEvents = "none";
        el.style.transform = "translateY(10px)";
    }, 250); // 👉 delay 250ms (KEY)
}
function toggleForm(){
    let f=document.getElementById("postForm");
    f.style.display = f.style.display==="block"?"none":"block";
}

function showReactions(id){
    let el = document.getElementById("react-"+id);
    el.style.opacity = "1";
    el.style.pointerEvents = "auto";
}

function hideReactions(id){
    let el = document.getElementById("react-"+id);
    el.style.opacity = "0";
    el.style.pointerEvents = "none";
}

function reactPost(postId, type){

    fetch("like.php", {
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"post_id="+postId+"&type="+type
    })
    .then(res=>res.text())
    .then(data=>{
        document.getElementById("like-"+postId).innerText=data;

        // 👉 đổi icon
        let btn = document.querySelector(`#like-${postId}`).parentNode;

        let iconMap = {
            like: "👍",
            love: "❤️",
            haha: "😂",
            wow: "😮",
            sad: "😢",
            angry: "😡"
        };

        btn.innerHTML = iconMap[type] + " <span id='like-"+postId+"'>"+data+"</span>";
    });

}

function focusComment(id){
    document.getElementById("cmt-"+id).focus();
}

function submitComment(e, postId){
    if(e.key==="Enter"){
        let content=e.target.value;

        fetch("comment.php",{
            method:"POST",
            headers:{"Content-Type":"application/x-www-form-urlencoded"},
            body:"post_id="+postId+"&content="+encodeURIComponent(content)
        })
        .then(res=>res.text())
        .then(html=>{
            document.getElementById("comments-"+postId).innerHTML=html;
            e.target.value="";
        });
    }
}
</script>

<?php include 'includes/footer.php'; ?>