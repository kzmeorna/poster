<?php

require_once(__DIR__ . '/../app/config.php');

$app=new \MyApp\Controller\Guest();

$app->run();


unset($_SESSION['userId']);

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>ゲストユーザー</title>
    <link rel="stylesheet" href="css/styles_guest.css">
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <!-- left part -->
      <div class="left">
        <img src="img/postIcon.png" alt="postIcon" class="postIcon">
        <div class="user">
          <p class="user-create">アカウント作成</p>
        </div>
        <div class="user">
          <p class="user-login">ログイン</p>
        </div>
        <div class="toTop">
          <a class="toTop" href="/index.php">トップページへ戻る</a>
        </div>
      </div>
      <!-- left part -->

      <div class="center">

        <p class="timeline-mode">
           最新投稿
        </p>

        <!-- tweet template -->
        <template class="template">
          <div class="post-list">
            <div class="profile">
              <a href="userpageforguest.php">
                <img src="img/notTopImg.png" alt="プロフィール" class="contributor">
              </a>
            </div>
            <p class="text">
              <span class="username"><?= $app->_userProf->name ?></span>
              <span class="userid"><?= $app->_userProf->userId ?></span>
              <span class="other">•••</span>
              <span class="postedText"></span>
            </p>
          </div>
        </template>
        <!-- tweet template -->

        <!-- time line start -->
        <div class="content tl" id="posts">
        </div>
        <!-- time line finish -->
      </div>
    </div>

    <script>
      var guestJson=JSON.stringify(<?= $app->guestJson ?>,null,'\t');
      var guest=JSON.parse(guestJson);
      var favsJson=JSON.stringify(<?= $app->_favsJson ?>,null,'\t');
      var favs=JSON.parse(favsJson);
      var topImgJson=JSON.stringify(<?= $app->_topImgJson ?>,null,'\t');
      var topImg=JSON.parse(topImgJson);
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="js/main3.js"></script>
  </body>

</html>

