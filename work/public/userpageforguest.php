<?php

require_once(__DIR__ . '/../app/config.php');

$app=new \MyApp\Controller\Userpage();

$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>profile</title>
    <link rel="stylesheet" href="css/styles_profforguest.css">
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <!-- left part start -->
      <div class="left">
        <img src="img/postIcon.png" alt="postIcon" class="postIcon">
        <div class="profile">
          <img src=<?=$app->leftTopPath?> alt="プロフィール" class="my_profile" width="50px" height="50px">
          <p>
            <span class="username"><?= $app->_userProf->name ?><br></span>
            <span class="userid">@<?= $app->_userProf->userId ?></span>
          </p>
        </div>
        <p class="logout"><a href="logout.php">ログアウト</a></p>
      </div>
      <!-- left part fin -->


      <!-- center part start -->
      <div class="center">
        <div class="prof">
          <p class="header">
            <img src=<?=$app->headerPath?> alt="ヘッダー" width=100% height="250px">
          </p>
          <div class="prof_text">
            <p class="prof_image">
              <img src=<?=$app->topPath?> alt="トップ画" width="200px" height="200px" class="my_profile">
              <span class="prof_refix"></span>
            </p>
            <div class="prof_container">
              <p class="user_name"><?= isset($app->_clickedUser)?$app->_clickedUser->name:$app->_userProf->name;?></p>
              <p class="user_id">@<?= isset($app->_clickedUser)?$app->_clickedUser->userId:$app->_userProf->userId ?></p>
              <p class="self_introduction">
              <?= isset($app->_clickedUser)?$app->_clickedUser->selfIntroduction:$app->_userProf->selfIntroduction; ?>
              </p>
            </div>
          </div>
        </div>

        <!-- タブ start -->
        <div class="tab_area">
          <div class="tab active">
            ツイート
          </div>
          <!-- <div class="tab">
            メディア
          </div> -->
          <div class="tab">
            いいね
          </div>
        </div>
        <!-- タブ finish -->
        
        <!-- tl start -->

        <div class="content_area">

          <!-- tweet template -->
          <template class="template">
            <div class="post-list" data-user="0" data-tweet="0">
              <a href="#" class="profile">
                <img src=<?=$app->topPath?> alt="プロフィール" class="contributor" width="50px" height="50px">
              </a>
              <p class="text">
                <span class="username"></span>
                <span class="userid"></span>
                <span class="other"></span>
                <span class="postedText"></span>
                <span class="favicon"><img src="img/hart-likegray.png" alt="ハートのアイコン"> </span>
              </p>
            </div>
          </template>
          <!-- tweet template -->

          <!-- tweet -->
          <div class="content show" id="posts">
            
          </div>
          <!-- tweet fin -->

          <!-- favorite -->
          <div class="content" id="favs">

          </div>
        </div>
        <!-- favorite fin -->
        <!-- tl finish-->
        
      </div>
      
    </div>

    <script>
      var json =JSON.stringify(<?php echo $app->_jsonArray?>,null,'\t');
      var php=JSON.parse(json);
      var jsonProf =JSON.stringify(<?php echo $app->_jsonProf?>,null,'\t');
      var prof=JSON.parse(jsonProf);
      var clickedUserJson =JSON.stringify(<?php echo $app->_clickedUserJson?>,null,'\t');
      var clickedUser=JSON.parse(clickedUserJson);
      var postsPersonalJson=JSON.stringify(<?php echo $app->_postsPersonalJson?>,null,'\t');
      var postsPersonal=JSON.parse(postsPersonalJson);
      var favsJson=JSON.stringify(<?php echo $app->_favsJson?>,null,'\t');
      var favs=JSON.parse(favsJson);
      var favedPostJson=JSON.stringify(<?php echo $app->_favedPostJson?>,null,'\t');
      var favedPost=JSON.parse(favedPostJson);
      var nameIdJson=JSON.stringify(<?php echo $app->_nameId?>,null,'\t');
      var nameId=JSON.parse(nameIdJson);
      var topPathJson=JSON.stringify(<?php echo $app->topPathJson?>,null,'\t');
      var topPath=JSON.parse(topPathJson);
      var favedTopPathJson=JSON.stringify(<?php echo $app->favedTopPathJson ?>,null,'\t');
      var favedTopPath=JSON.parse(favedTopPathJson);
      var favedPostNumJson=JSON.stringify(<?= $app->favedPostNum ?>,null,'\t');
      var favedPostNum=JSON.parse(favedPostNumJson);
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="js/main4.js"></script>
  </body>

</html>

