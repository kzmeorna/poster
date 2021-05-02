<?php

namespace MyApp\Controller;

class Home extends \MyApp\Controller{
  
  public $_postsTable;
  public $_favs;
  public $_favsJson;
  public $_userNumber;
  public $_userNumberJson;
  public $topPath;
  public $_topImg;
  public $favedPostNum;

  public function __construct(){
    $this->_topPath=new \stdClass();
  }

  public function run(){

    if(!isset($_SESSION['me'])){
      header('Location:'. SITE_URL . '/index.php');
      exit;
    }

    // ツイートの投稿 start
    if($_SERVER['REQUEST_METHOD']==='POST'){
      $this->postProcess();
    }
    // ツイートの投稿 fin

    $this->_userProf=$this->fetchProf();
    $res=$this->getTl();

    // userNumberの取得start
    $this->_userNumber=$this->_userProf->userNumber;
    $this->_userNumberJson=json_encode($this->_userNumber);

    // userNumberの取得fin

    // tl上のツイートのいいね表示start
    $post=new \MyApp\Model\functionPost;
    $this->_postsTable=$post->getpostsTable();
    for($i=0;$i<count($this->_postsTable);$i++){
      // var_dump($app->_test[$i]->favorites);
      $this->_favs[]=$this->_postsTable[$i]->favorites;
    }
    $this->_favsJson=json_encode($this->_favs);
    // tl上のツイートのいいね表示fin

    // プロフ画像の取得start
    $img=new \MyApp\Model\Image();
    $this->topPath=$img->fetchImages(typTop,$_SESSION['me']);
    // プロフ画像の取得fin

    // test
    // var_dump($tweet->duplicateFav());
    // test

    $this->_topImg=json_encode($img->getTopImg());

    // ユーザーごとのお気に入りのツイート番号の取得start
    $this->favedPostNum=json_encode($post->favKeep($_SESSION['me']));
    // ユーザーごとのお気に入りのツイート番号の取得fin

    
    // //encode to json start
    if(isset($res)){
      $this->_json_array=json_encode($res,JSON_PRETTY_PRINT);
    }else{
      echo 'sorry';
    }
    // //encode to json fin
  }

  // タイムラインの取得 start
  public function getTl(){
    $read=new \MyApp\Model\functionPost;
    $postInfo=$read->readingAllUsersPosts();
    return $postInfo;
  }
  // タイムラインの取得 fin
  
}