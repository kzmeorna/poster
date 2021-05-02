<?php

namespace MyApp\Controller;

class Signup extends \MyApp\Controller{
  
  public function run(){
  
    if($_SERVER['REQUEST_METHOD']==='POST'){
      $this->checkToken();
      $this->postProcess();
    }else{
      $this->setToken();
    }
  }

  public function postProcess(){

    // validate
    try{
      $this->_validate();
    }catch(\MyApp\Exception\emailValidate $e){
      // echo $e->getMessage();
      $this->setErrors('email',$e->getMessage());
    }catch(\MyApp\Exception\passwordValidate $e){
      // echo $e->getMessage();
      $this->setErrors('password',$e->getMessage());
    }

    try{
      $this->_duplication();
    }catch(\MyApp\Exception\duplicateEmail $e){
      // echo $e->getMessage();
      $this->setErrors('duplicateEmail',$e->getMessage());
    }

    //insert
  
    if(isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']) && 
    filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
      $pass=$this->hashPass();
      $signup=new \MyApp\Model\User();
      $res=$signup->userCreate($pass);

      //redirect to home
      if($res){
        $user=new \MyApp\Model\User;
        $userNumber=$user->fetchUserNumber();
        $_SESSION['me']=$userNumber;
        $id=$user->fetchUserId();
        $name=$user->fetchUserName();
        if(is_null($id->userId) && is_null($name->name)){
          header('Location:'.'http://'.SITE_URL . '/idname.php');
        }else{
          header('Location:'.'http://'.SITE_URL . '/home.php');
        }
      }
    }

  }
  
}