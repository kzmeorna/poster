<?php

namespace MyApp\Controller;

class Userpage extends \MyApp\Controller{
  
  public $_posts;
  public $_postsPersonal;
  public $_user;
  public $_clickedUser;
  public $_jsonArray;
  public $_jsonProf;
  public $_postsPersonalJson;
  public $_favs;
  public $_favsJson;
  public $_favedPostJson;
  public $_nameId;
  public $headerPath;
  public $topPath;
  public $leftTopPath;
  public $topPathJson;
  public $favedTopPath;
  public $favedTopPathJson;
  public $favedPostNum;

  public function run(){
    $post=new \MyApp\Model\functionPost();
    $user= new \MyApp\Model\User();
    $img=new \MyApp\Model\Image();

    if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['text'])){
      $this->postProcess();
    }

    $this->_posts=$post->readingPosts();
    $this->_prof=$user->fetchUserProf();

    // ユーザーページの表示start
    if(isset($_SESSION['userId'])){        //任意のユーザーを選択した場合
      $this->_clickedUser=$user->showProf($_SESSION['userId']);
      $this->_postsPersonal=$user->getPosts();
      // var_dump($this->_tweetsPersonal);
    }else{                                 //自分のプロフを表示する場合
      $userId=$user->fetchUserId();
      $this->_clickedUser=$user->showProf($userId->userId);
      $this->_postsPersonal=$user->getPosts();
    }
    // ユーザーページの表示fin

    //encode to json start
    if(isset($this->_posts) && isset($this->_prof)){
      $this->_jsonArray=json_encode($this->_posts,JSON_PRETTY_PRINT);
      $this->_jsonProf=json_encode($this->_prof);
    }else{
      echo 'sorry';
    }
      $this->_postsPersonalJson=json_encode($this->_postsPersonal);
      $this->_clickedUserJson=json_encode($this->_clickedUser);
    //encode to json fin

    $this->_userProf=$this->fetchProf();

    // var_dump($this->_userProf);

    $allPosts=$post->readingAllPosts();
    $personalPosts=$user->getPosts();
    // var_dump($personalTweets);

    if(empty($personalPosts)){
      $favs=0;
    }

    for($i=0;$i<count($personalPosts);$i++){
      $fav=$post->returnFav($personalPosts[$i]->postNumber);
      $favs[]=$fav[0];
    }

    if(isset($favs)){
      $this->_favs=$favs;
      $this->_favsJson=json_encode($this->_favs);
    }

    if($this->_clickedUser->userNumber===$_SESSION['me']){
      // ログイン中のユーザーのimgPathの抽出start
      $this->headerPath=$img->fetchImages(typHeader,$_SESSION['me']);
      $this->topPath=$img->fetchImages(typTop,$_SESSION['me']);
      $this->leftTopPath=$img->fetchImages(typTop,$_SESSION['me']);
      // ログイン中のユーザーのimgPathの抽出fin
    }else{
      // 自分以外のユーザーのimgPathの抽出start
      $this->leftTopPath=$img->fetchImages(typTop,$_SESSION['me']);
      $this->headerPath=$img->fetchImages(typHeader,$this->_clickedUser->userNumber);
      $this->topPath=$img->fetchImages(typTop,$this->_clickedUser->userNumber);
      // 自分以外のユーザーのimgPathの抽出fin
    }

    // topPathをJSONへstart
    $this->topPathJson=json_encode($this->topPath);
    // topPathをJSONへfin

    // いいね欄の表示start
    // if(isset($this->_userProf)){
    if(isset($_SESSION['userId'])){
      $this->_clickedUser=$user->showProf($_SESSION['userId']);
      $userNumber=$this->_clickedUser->userNumber;
      $postNumber=$post->getPostNumber($userNumber);

      if(!empty($postNumber)){
        for($i=0;$i<count($postNumber);$i++){
          $userNumber=$user->getUserNumber($postNumber[$i]->postNumber);
          $NameId[]=$user->fetchNameId($userNumber);
          $tmp[]=$post->getFavedPost($postNumber[$i]->postNumber);
          $favedPost[]=$tmp[$i][0];
          $favedPathArray[]=$img->fetchImages(typTop,$userNumber);
        }
        $this->favedTopPath=$favedPathArray;
        $this->favedTopPathJson=json_encode($this->favedTopPath);
        $this->_nameId=json_encode($NameId);
        $this->_favedPostJson=json_encode($favedPost);
      }else{
        $this->_nameId=json_encode(array(0));
        $this->_favedPostJson=json_encode(array(0));
        $this->favedTopPathJson=json_encode(array(0));
      }
      
    }else{
      $postNumber=$post->getPostNumber($this->_userProf->userNumber);
      
      if(!empty($postNumber)){
        for($i=0;$i<count($postNumber);$i++){
          $userNumber=$user->getUserNumber($postNumber[$i]->postNumber);
          $NameId[]=$user->fetchNameId($userNumber);
          $tmp[]=$post->getFavedPost($postNumber[$i]->postNumber);
          $favedPost[]=$tmp[$i][0];
          $favedPathArray[]=$img->fetchImages(typTop,$userNumber);
        }
        $this->favedTopPath=$favedPathArray;
        $this->favedTopPathJson=json_encode($this->favedTopPath);
        $this->_nameId=json_encode($NameId);
        $this->_favedPostJson=json_encode($favedPost);
      }else{
        $this->_nameId=json_encode(array(0));
        $this->_favedPostJson=json_encode(array(0));
        $this->favedTopPathJson=json_encode(array(0));
      }
    }
    // いいね欄の表示fin

    // ユーザーごとのお気に入りのツイート番号の取得start
    $this->favedPostNum=json_encode($post->favKeep($_SESSION['me']));
    // ユーザーごとのお気に入りのツイート番号の取得fin
    

    // $this->favs=$favs;
    
    
    //refix prof fin

  }




  // tweets reading
  

}