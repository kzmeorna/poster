<?php

namespace MyApp\Model;

class User extends \MyApp\Model {
  public $_id;
  public $guest;

  public function fetchUserNumber(){
    $stmt=$this->_db->prepare("select userNumber from users where email=:email");
    $stmt->bindValue(':email',$_POST['email']);
    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_COLUMN);
  }

  public function userCreate($password){
    $stmt=$this->_db->prepare("insert into users(email,password) Values(:email,:password)");
    $stmt->bindValue(':email',$_POST['email']);
    $stmt->bindValue(':password',$password);
    return $stmt->execute();
  }

  public function fetchUserId(){
    $stmt=$this->_db->prepare("select userId from users where userNumber=:number");
    $stmt->bindValue(':number',$_SESSION['me']);
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  
  public function fetchUserName(){
    $stmt=$this->_db->prepare("select name from users where userNumber=:number");
    $stmt->bindValue(':number',$_SESSION['me']);
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public function insertIdName(){
    $stmt=$this->_db->prepare("update users set name=:name,userId=:userId where userNumber=:number");
    $stmt->bindValue(':name',$_POST['name']);
    $stmt->bindValue(':userId',$_POST['userId']);
    $stmt->bindValue(':number',$_SESSION['me']);
    return $stmt->execute();
  }

  public function emailFetch(){
    $stmt=$this->_db->query("select email from users");
    return $stmt->fetchAll(\PDO::FETCH_COLUMN);
  }

  public function passFetch(){
    $stmt=$this->_db->prepare("select password from users where email = :email");
    $stmt->bindValue(':email',$_POST['email'],\PDO::PARAM_STR);
    $res=$stmt->execute();
    return $res?$stmt->fetch(\PDO::FETCH_OBJ) : '';
  }

  public function fetchUserProf(){
    if($_SESSION['me']!=='guest'){
      $stmt=$this->_db->prepare("select * from users where userNumber=:number");
      $stmt->bindValue(':number',$_SESSION['me']);
      $stmt->execute();
  
      return $stmt->fetch(\PDO::FETCH_OBJ);
    }else{
      $this->guest=new \stdClass();
      $this->guest->name='?????????';
      $this->guest->userId='guest';
      return $this->guest;
    }
  }

  public function refixProf($_name,$_selfIntroduction){
    $stmt1=$this->_db->prepare("update users set name=:name where userNumber=:number");
    $stmt1->bindValue(':name',$_name);
    $stmt1->bindValue(':number',$_SESSION['me']);
    $stmt1->execute();

    $stmt2=$this->_db->prepare("update users set selfIntroduction=:self where userNumber=:number");
    $stmt2->bindValue(':self',$_selfIntroduction);
    $stmt2->bindValue(':number',$_SESSION['me']);
    $stmt2->execute();
  }

  // profile?????????start
  public function showProf($id){
    $stmt=$this->_db->prepare("select * from users where userId=:id");
    $stmt->bindValue(':id',$id);
    $stmt->execute();
    
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }
  // profile?????????fin

  // ??????????????????????????????????????????start
  public function getPosts(){
    $userId=$this->fetchUserid();
    isset($_SESSION['userId'])?$prof=$this->showProf($_SESSION['userId']):$prof=$this->showProf($userId->userId);
    $number=$prof->userNumber;
    $stmt=$this->_db->prepare("select postNumber,post from posts where userNumber=:number order by postNumber desc");
    $stmt->bindValue(':number',$number);
    $stmt->execute();
    return $tweet=$stmt->fetchAll(\PDO::FETCH_CLASS);
  }
  // ??????????????????????????????????????????fin

  // tweetNumber??????userNumber?????????start
  public function getUserNumber($postNumber){
    $stmt=$this->_db->prepare('select userNumber from posts where postNumber=:number');
    $stmt->bindValue(':number',$postNumber);
    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_COLUMN);
  }
  // tweetNumber??????userNumber?????????fin

  // userNumber???????????????????????????ID?????????start
  public function fetchNameId($userNumber){
    $stmt=$this->_db->prepare('select name,userId from users where userNumber=:number');
    $stmt->bindValue(':number',$userNumber);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_CLASS);
  }
  // userNumber???????????????????????????ID?????????fin


  // ?????????????????????????????????????????????????????????????????????start
  public function judgmentId($userId){
    // $res= ($_SESSION['userId']===$userId) || !isset($_SESSION['userId']) ? true:false;
    // return $res;

    if(!isset($_SESSION['userId'])){
      return $res =true;
    }elseif(($_SESSION['userId']===$userId)){
      return $res=true;
    }else{
      return $res=false;
    }
    
  }
  // ?????????????????????????????????????????????????????????????????????fin
}