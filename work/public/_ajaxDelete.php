<?php

require_once(__DIR__ . '/../app/config.php');

require_once(__DIR__ . '/../app/Model/functionPost.php');

$post=new \MyApp\Model\functionPost;
$user= new \MyApp\Model\User;
$image=new \MyApp\Model\Image;

// ajax 通信

header('Content-type: application/json; charset=utf-8'); // ヘッダ（JSON指定など）

// 削除処理start
$postNumber=$_POST['deletePostNumber'];
$res=$post->deletePosts($postNumber);
// 削除処理fin

// jqueryに返すstart
echo json_encode($res);
// jqueryに返すfin