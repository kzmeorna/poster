<?php

require_once(__DIR__ . '/../app/config.php');

require_once(__DIR__ . '/../app/Model/functionPost.php');

$post=new \MyApp\Model\functionPost;
$user= new \MyApp\Model\User;
$image=new \MyApp\Model\Image;

// ajax 通信

header('Content-type: application/json; charset=utf-8'); // ヘッダ（JSON指定など）

$fileHeader=$_FILES['header'];
$fileTop=$_FILES['top'];
$name=$_POST['name'];
$selfIntroduction=$_POST['selfIntroduction'];

// プロフィールの変更start
if(isset($name) || isset($selfIntroduction)){
  $user->refixProf($name,$selfIntroduction);
}
// プロフィールの変更fin

//ヘッダー画像の登録start
if($image->imgValidate($fileHeader)){
  $_SESSION['error']='画像がない';
  if($image->searchImg(typHeader)){
    $image->insertImages($fileHeader['tmp_name'],typHeader);
    // var_dump($image->searchImg(typHeader));
  }else{
    $image->updateImages($fileHeader['tmp_name'],typHeader);
    // var_dump($image->searchImg(typHeader));
  }
}else{
  // echo '画像がセットされていません';
  $_SESSION['error']='画像がない';
}
// fin

// プロフィール画像の登録start
if($image->imgValidate($fileTop)){
  $_SESSION['error']='画像がない';
  // if(true){
  if($image->searchImg(typTop)){
    $image->insertImages($fileTop['tmp_name'],typTop);
    // var_dump($image->searchImg(typTop));
  }else{
    $image->updateImages($fileTop['tmp_name'],typTop);
    // var_dump($image->searchImg(typTop));
  }
}else{
  // echo '画像がセットされていません';
  $_SESSION['error']='画像がない';
}
  //fin

