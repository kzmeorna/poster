<?php 

namespace MyApp;

class Controller extends \MyApp\Model{
  public $_errors;
  public $_userProf;

  public function __construct(){
    $this->_errors=new \stdClass();
    $this->_userProf=new \stdClass();
  }

  public function setToken(){
    $_SESSION['csrf']=bin2hex(openssl_random_pseudo_bytes(16));
  }

  public function checkToken(){
    if(empty($_SESSION['csrf'])||($_SESSION['csrf']!==$_POST['csrf'])){
      echo "不正なPOSTが行われました。";
      // print_r($_POST['csrf']);
      // echo "\n";
      // print_r($_SESSION['csrf']);
      // exit;
    }

  }

  public function _validate(){
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
      throw new \MyApp\Exception\emailValidate();
    }

    if(!preg_match('/\A[a-zA-Z0-9]+\z/',$_POST['password'])){
      throw new \MyApp\Exception\passwordValidate();
    }
  }

  protected function _duplication(){
    $email= new \MyApp\Model\User;
    $list=$email->emailFetch();
    if(in_array($_POST['email'],$list)){
      throw new \MyApp\Exception\duplicateEmail();
    }
  }
  
  public function setErrors($key,$message){
    $this->_errors->$key=$message;
    // var_dump($this->_errors->$key);
  }

  public function getErrors($key){
    return isset($this->_errors->$key) ? $this->_errors->$key : '';
  }

  // fetchuserprof

  public function fetchProf(){
    $fetch=new \MyApp\Model\User;
    return $fetch->fetchUserprof();
  }

  // passwordのハッシュ化start
  public function hashPass(){
    return password_hash($_POST['password'],PASSWORD_DEFAULT);
  }
  // passwordのハッシュ化fin

  // postprocess start
  public function postProcess(){
    //checkTweet
    try{
      $this->checkPost();
    }catch(\MyApp\Exception\nullText $e){
      echo $e->getMessage();
      exit;
    }
    
    //insert into Tweets table
    if(!empty($_POST['text'])){
      echo 'Hello';
      $post=new \MyApp\Model\functionPost;
      $res=$post->postingTexts();
      // redirect to home
      if($res){
        header('Location:'.'http://' . SITE_URL . '/home.php');
      }
    }
  }
  // postprocess fin

  // check tweet start
  public function checkPost(){
    if(empty($_POST['text'])){
      throw new \MyApp\Exception\nullText;
    }
  }
  // check tweet fin
  
}