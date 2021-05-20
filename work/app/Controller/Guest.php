<?php

namespace MyApp\Controller;

class Guest extends \MyApp\Controller{
  
  public $_postsTable;
  public $_favs;
  public $_favsJson;
  public $_userNumber;
  public $_userNumberJson;
  public $topPath;
  public $_topImgJson;
  public $favedPostNum;
  public $guest;
  public $guestJson;

  public function __construct(){
    $this->_topPath=new \stdClass();
    $this->guest=new \stdClass();
    $_SESSION['me']='guest';
  }

  public function run(){

    if(!isset($_SESSION['me'])){
      header('Location:'. '/index.php');
      exit;
    }

    // tl取得start
    $res=$this->getTl();
    $this->guestJson=json_encode($res);
    // tl取得fin

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

    $this->_topImgJson=json_encode($img->getTopImg());

    // ユーザーごとのお気に入りのツイート番号の取得start
    $this->favedPostNum=json_encode($post->favKeep($_SESSION['me']));
    // ユーザーごとのお気に入りのツイート番号の取得fin

    
  }

  // タイムラインの取得 start
  public function getTl(){
    $read=new \MyApp\Model\functionPost;
    $postInfo=$read->readingAllUsersPosts();
    return $postInfo;
  }
  // タイムラインの取得 fin
  
}