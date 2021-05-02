<?php

require_once(__DIR__ . '/../app/config.php');

$app=new \MyApp\Controller\Idname;
$app->run();

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ユーザーid,ユーザーネーム作成</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
  </head>
  <body>
    <!-- idname登録 -->
    <div class="userinfo">
        <img src="img/postIcon.png" alt="whey_icon">
        <form action="" method='post'>
          <p class="name">
            <input type="text" name="name" placeholder="ユーザーネーム">
            <span class="fs12"><?= h($app->getErrors('email')) ?></span>
          </p>
          <p class="user_id">
            <input type="text" name="userId" placeholder="ユーザーID">
            <span class="fs12"><?= h($app->getErrors('password')) ?></span>
          </p>
          <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
          <a class="button">登録</a>
        </form>
      </div>
    <!--idname登録 -->  
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>