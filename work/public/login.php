<?php

require_once(__DIR__ . '/../app/config.php');

$app=new \MyApp\Controller\Login;
$app->run();

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
  </head>
  <body>
    <!-- ログイン画面 -->
    <div class="login">
        <img src="img/postIcon.png" alt="postIcon">
        <p>ログイン</p>
        <form action="" method='post'>
          <p class="email">
            <input type="text" name="email" placeholder="email Please.">
            <span class="fs12"><?= h($app->getErrors('email')) ?></span>
          </p>
          <p class="password">
            <input type="password" name="password" placeholder="password Please.">
            <span class="fs12"><?= h($app->getErrors('password')) ?></span>
          </p>
          <a class="button">ログイン</a>
          <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        </form>
      </div>
    <!--ログイン画面 -->  
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>