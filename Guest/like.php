<?php
session_start();
include 'config.php';

$user_id = $_SESSION['khach_hang']['id_khach_hang'];
$post_id = $_POST['post_id'];
$type = $_POST['type'] ?? 'like';

// kiểm tra đã react chưa
$check = mysqli_query($conn,"
SELECT * FROM post_likes 
WHERE post_id=$post_id AND user_id=$user_id");

if(mysqli_num_rows($check)>0){
    mysqli_query($conn,"
    UPDATE post_likes 
    SET type='$type'
    WHERE post_id=$post_id AND user_id=$user_id");
}else{
    mysqli_query($conn,"
    INSERT INTO post_likes(post_id,user_id,type)
    VALUES($post_id,$user_id,'$type')");
}

// trả tổng
$res = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total FROM post_likes WHERE post_id=$post_id"));

echo $res['total'];