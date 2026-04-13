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
    gap:20px;
    border-top:1px solid #ddd;
    padding:8px 12px;
}

/* REACTION */
.reaction-box { position: relative; }

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
    transition: 0.2s;
    transform: translateY(10px);
}

.reaction-list span {
    font-size:22px;
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
    border:none;
    background:transparent;
    cursor:pointer;
}

/* MODAL */
.react-modal{
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.4);
    display:none;
    justify-content:center;
    align-items:center;
}
.react-content{
    width:400px;
    background:#fff;
    border-radius:10px;
    padding:10px;
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

<!-- 👉 AUTO LOAD POSTS -->
<div id="post-list"></div>

</div>

<!-- MODAL -->
<div id="reactModal" class="react-modal">
    <div class="react-content">
        <div style="display:flex;justify-content:space-between">
            <span>Tất cả</span>
            <button onclick="closeReact()">✖</button>
        </div>
        <div id="reactList"></div>
    </div>
</div>

<script>
let hideTimeout;

function showReact(id){
    clearTimeout(hideTimeout);
    let el = document.getElementById("react-"+id);
    if(!el) return;
    el.style.opacity = "1";
    el.style.pointerEvents = "auto";
    el.style.transform = "translateY(0)";
}

function hideReact(id){
    hideTimeout = setTimeout(()=>{
        let el = document.getElementById("react-"+id);
        if(!el) return;
        el.style.opacity = "0";
        el.style.pointerEvents = "none";
        el.style.transform = "translateY(10px)";
    }, 200);
}

function toggleForm(){
    let f=document.getElementById("postForm");
    f.style.display = f.style.display==="block"?"none":"block";
}

function reactPost(postId, type){
    fetch("like.php", {
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"post_id="+postId+"&type="+type
    })
    .then(res=>res.text())
    .then(data=>{
        let el = document.getElementById("like-"+postId);
        if(el) el.innerText = data;
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

function openReactList(postId){
    fetch("get_reacts.php?post_id="+postId)
    .then(res=>res.text())
    .then(html=>{
        document.getElementById("reactList").innerHTML = html;
        document.getElementById("reactModal").style.display="flex";
    });
}

function closeReact(){
    document.getElementById("reactModal").style.display="none";
}

/* 🚀 AUTO LOAD */
function loadPosts(){
    fetch("load_posts.php")
    .then(res => res.text())
    .then(html => {
        document.getElementById("post-list").innerHTML = html;
    });
}

// load lần đầu
loadPosts();

// load mỗi 3 giây
setInterval(loadPosts, 3000);
</script>

<?php include 'includes/footer.php'; ?>