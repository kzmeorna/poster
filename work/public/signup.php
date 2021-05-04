<?php

require_once(__DIR__ . '/../app/config.php');

$app=new \MyApp\Controller\Signup();
$app->run();

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>新規登録</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
  </head>
  <body>
    <!-- 新規登録 -->
    <div class="signup">
        <img src="img/postIcon.png" alt="postIcon" class="postIcon">
        <p>アカウントを作成</p>
        <form action="" method='post'>
          <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
          <p class="email">
            <input type="text" name="email" placeholder="email Please.">
            <span class="fs12"><?= h($app->getErrors('email')); ?></span>
            <span class="fs12"><?= h($app->getErrors('duplicateEmail')); ?></span>
          </p>
          <p class="password">
            <input type="password" name="password" placeholder="password Please.">
            <span class="fs12"><?= h($app->getErrors('password')); ?></span>
          </p>
          <a class="button">登録</a>
        </form>
      </div>
    <!-- 新規登録 -->  
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>