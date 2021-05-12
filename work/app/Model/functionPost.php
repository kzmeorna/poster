<?php

namespace MyApp\Model;

class functionPost extends \MyApp\Model {
  //個人のツイートの読み込みstart
  public function readingPosts(){
    $stmt=$this->_db->prepare("select post from posts where postNumber=:number order by postNumber desc");
    $stmt->bindValue(':number',$_SESSION['me']);
    $stmt->execute();
    $posts=$stmt->fetchAll(\PDO::FETCH_OBJ);
    return $posts;
  }
  //個人のツイートの読み込みfin

  // 全登録ユーザーのツイートの読み込みstart
  public function readingAllUsersPosts(){
    $stmt=$this->_db->query("select * from users inner join posts on posts.userNumber=users.userNumber order by postNumber desc;");
    return $stmt->fetchAll(\PDO::FETCH_CLASS);
  }
  // 全登録ユーザーのツイートの読み込みfin

  public function readingAllPosts(){
    $stmt=$this->_db->query("select postNumber from users inner join posts on posts.userNumber=users.userNumber order by postNumber desc;");
    return $stmt->fetchAll(\PDO::FETCH_COLUMN);
  }

  // ツイートの投稿
  public function postingTexts(){
    $stmt=$this->_db->prepare("insert into posts (userNumber,post) values(:number,:post)");
    $stmt->bindValue(':number',$_SESSION['me']);
    $stmt->bindValue(':post',$_POST['text']);
    return $stmt->execute();
  }

  // ツイートの削除

  public function deletePosts($number){
    $stmt=$this->_db->prepare('delete post,favorite from posts as post left join favorites as favorite on post.postNumber = favorite.userNumber where post.postNumber=:number');
    $stmt->bindValue(':number',$number);
    return $stmt->execute();
  }

  // ツイートの情報取得 start
  public function getPostsInfo($post){
    $stmt=$this->_db->prepare("select * from posts where post=:post");
    $stmt->bindValue(':post',$post);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_CLASS);
  }
  // ツイートの情報取得 fin

  // 二重いいね防止start
  public function duplicateFav(){
    // いいねの重複があればtrue を返す
    $stmt=$this->_db->prepare("select favoriteNumber from favorites where userNumber=:userNumber && postNumber=:postNumber");
    $stmt->bindValue(':userNumber',$_POST['userNumber']);
    $stmt->bindValue(':postNumber',$_POST['postNumber']);
    $stmt->execute();

    $favNum=$stmt->fetchAll(\PDO::FETCH_COLUMN);
    // var_dump($favNum);
    // return $favNum;
    return !empty($favNum);
  }
  // 二重いいね防止fin

  // いいねの登録start
  public function registerFav(){
    $stmt=$this->_db->prepare("insert into favorites(userNumber,postNumber) Values(:userNumber,:postNumber)");
    $stmt->bindValue(':userNumber',$_POST['userNumber']);
    $stmt->bindValue(':postNumber',$_POST['postNumber']);
    $stmt->execute();
    
  }
  // いいねの登録fin

  // いいねの削除start
  public function deleteFav(){
    $stmt=$this->_db->prepare("delete from favorites where userNumber=:userNumber && postNumber=:postNumber");
    $stmt->bindValue(':userNumber',$_POST['userNumber']);
    $stmt->bindValue(':postNumber',$_POST['postNumber']);
    $stmt->execute();
  }
  // いいねの削除fin

  // いいねの登録・削除の処理start
  public function toggleFav(){
    if($this->duplicateFav()){
      $this->deleteFav();
    }else{
      $this->registerFav();
    }

  }
  // いいねの登録・削除の処理fin

  // favoritetableからいいね数の抽出start
  public function pullOutQuantity($number){
    $stmt=$this->_db->prepare("select favoriteNumber from favorites where postNumber=:number");
    $stmt->bindValue(':number',$number);
    $stmt->execute();

    $quantity=$stmt->fetchAll(\PDO::FETCH_COLUMN);
    return count($quantity);
  }
  // favoritetableからいいね数の抽出fin

  // tweetstableのfavoritesにいいね数の更新start
  public function favQuantity($favQuantity,$postNumber){
    $stmt=$this->_db->prepare('update posts set favorites=:favorites where postNumber=:number');
    $stmt->bindValue(':favorites',$favQuantity);
    $stmt->bindValue(':number',$postNumber);
    $stmt->execute();
  }
  // tweetstableのfavoritesにいいね数の更新fin

  // tweetstableからいいね数を返すメソッドstart
  public function returnFav($postNumber){
    $stmt=$this->_db->prepare("select favorites from posts where postNumber=:number");
    $stmt->bindValue(':number',$postNumber);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_COLUMN);
  }
  // tweetstableからいいね数を返すメソッドfin

  // tweetstableのデータを抽出start
  public function getPostsTable(){
    $stmt=$this->_db->query('select * from posts order by postNumber desc');

    return $stmt->fetchAll(\PDO::FETCH_CLASS);
  }
  // tweetstableのデータを抽出fin

  // favorites table からtweetNumberの抽出start
  public function getPostNumber($userNumber){
    $stmt=$this->_db->prepare("select postNumber from favorites where userNumber=:number");
    $stmt->bindValue(':number',$userNumber);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_CLASS);
  }
  // favorites table からtweetNumberの抽出fin

  // いいね欄のtweetの抽出(tweetNumberよりtweets table から該当するtweetを抽出)start
  public function getFavedPost($postNumber){
    $stmt=$this->_db->prepare("select * from posts where postNumber=:number");
    $stmt->bindValue(':number',$postNumber);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_CLASS);
  }
  // いいね欄のtweetの抽出(tweetNumberよりtweets table から該当するtweetを抽出)fin

  public function favKeep($userNumber){
    $stmt=$this->_db->query('select * from favorites');    
    $favList=$stmt->fetchAll(\PDO::FETCH_CLASS);
    $postNum=[];
    for($i=0;$i<count($favList);$i++){
      $favListArr=(array)$favList[$i];
      if(in_array($userNumber,$favListArr)){
        $postNum[]=$favListArr['postNumber'];
      }
    }

    // return $favListArr['tweetNumber'];
    return $postNum;
  }
  // いいね状態の保持fin

}