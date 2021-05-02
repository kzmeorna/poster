<?php

require_once(__DIR__ . '/../app/config.php');

require_once(__DIR__ . '/../app/Model/functionPost.php');

$post=new \MyApp\Model\functionPost;
$user= new \MyApp\Model\User;
$image=new \MyApp\Model\Image;

// ajax 通信

header('Content-type: application/json; charset=utf-8'); // ヘッダ（JSON指定など）

// jsから送ったデータを受け取る
$bool = filter_input(INPUT_POST, 'bool'); 
$name = filter_input(INPUT_POST,'name');
$selfIntroduction = filter_input(INPUT_POST,'selfIntroduction');
$userId=filter_input(INPUT_POST,'userId');
$postNumber=filter_input(INPUT_POST,'postNumber');
$fav=filter_input(INPUT_POST,'fav');
$booldone=filter_input(INPUT_POST,'booldone');

//表示するデータ
if($bool){
  $param=$post->deletePosts();
}

//refix prof start
if(isset($name) || isset($selfIntroduction)){
  $user->refixProf($name,$selfIntroduction);
}

// プロフ頁の表示
if(isset($userId)){
  $_SESSION['userId']=$userId;
}

// favtweetの取得
// $tweetInfo=$tweet->getTweetsInfo($favtweet);

// いいねのデータベースへの登録
$post->toggleFav();
$favQuantity=$post->pullOutQuantity($postNumber);
$post->favQuantity($favQuantity,$postNumber);
// いいねのデータベースへの登録

// main.jsへの返り値
if($post->duplicateFav()){
  echo json_encode($fav+1);
  // echo json_encode($booldone);
}else{
  echo json_encode($fav-1);
  // echo json_encode($booldone);
}
// echo json_encode($param);

