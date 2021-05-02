<?php

require_once(__DIR__ . '/../app/config.php');

$app=new \MyApp\Controller\Home();

$app->run();


unset($_SESSION['userId']);

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>home</title>
    <link rel="stylesheet" href="css/styles_home.css">
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <!-- left part -->
      <div class="left">
        <img src="img/postIcon.png" alt="postIcon" class="postIcon">
        <ul>
          <li class="home visited">ホーム</li>
          <li><a href="userpage.php">プロフィール</a></li>
        </ul>
        <p class="doPost">投函する</p>
        <div class="profile">
          <a>
            <img src=<?= $app->topPath ?> alt="プロフィール" class="my_profile">
          </a>
          <p>
            <span class="username"><?= $app->_userProf->name ?><br></span>
            <span class="userid">@<?= $app->_userProf->userId ?></span>
          </p>
        </div>
        <p class="logout"><a href="logout.php">ログアウト</a></p>
      </div>

      <!-- 記事投稿モーダルウィンドウstart -->
      <div class="modalContent">
        <div class="createPost">
          <span class="close">×</span>
          <form action="" method="post" class="modal_post">
            <div class="postText">
              <img src=<?= $app->topPath ?> alt="プロフィール" class="my_profile">
              <textarea name="text" placeholder="いまどうしてる？" rows="6"></textarea>
              <input type='hidden' name='email' value="<?= $_SESSION['me']  ?>">
            </div>
          </form>
          <button class="post">
            投函する
          </button>
        </div>
      </div>
      <!-- 記事投稿モーダルウィンドウfin -->

      <!-- center part -->
      <div class="center">
        <div class="createPost">
          <p class="timeline-mode">
            最新投稿
          </p>
          <form action="" method="post" class="clearfix post_Text">
            <div class="postText">
              <a href="userpage.php">
                <img src=<?= $app->topPath ?> alt="プロフィール" class="my_profile">
              </a>
              <textarea name="text" placeholder="いまどうしてる？"></textarea>
              <input type='hidden' name='email' value="<?= $_SESSION['me']  ?>">
            </div>
            <button class="post">
              投函する
            </button>
          </form>
        </div>

        <!-- tweet template -->
        <template class="template">
          <div class="post-list">
            <div class="profile">
              <a href="userpage.php">
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
      var json =JSON.stringify(<?php echo $app->_json_array?>,null,'\t');
      var php=JSON.parse(json);
      var favsJson =JSON.stringify(<?php echo $app->_favsJson?>,null,'\t');
      var favs=JSON.parse(favsJson);
      var userNumberJson=JSON.stringify(<?php echo $app->_userNumberJson?>,null,'\t');
      var userNumber2=JSON.parse(userNumberJson);
      var topImgJson=JSON.stringify(<?php echo $app->_topImg ?>,null,'\t');
      var topImg=JSON.parse(topImgJson);
      var favedPostNumJson=JSON.stringify(<?= $app->favedPostNum ?>,null,'\t');
      var favedPostNum=JSON.parse(favedPostNumJson);
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="js/main2.js"></script>
  </body>

</html>

