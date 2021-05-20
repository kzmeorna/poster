<?php

  require_once(__DIR__ . '/../app/config.php');

  $app=new \MyApp\Controller\Index();
  $app->run();

?>


<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/styles.css">
    <title>誰宛でもない投稿|Poster</title>
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <img class="top" src="img/posterTop.png" alt="posterTop" width="576px" height="600px">
      <div class="text">
        <span class="catch">こんな世の中だからこそ独り言を吐き出そう。</span>
        <span class="start">Posterをはじめよう</span>
        <div class="user">
          <p class="user-create">アカウント作成</p>
        </div>
        <div class="user">
          <p class="user-login">ログイン</p>
        </div>
        <div class="user">
          <p class="guest-login">
            ゲストでログインする
          </p>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>