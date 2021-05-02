<?php

namespace MyApp\Controller;

class Login extends \MyApp\Controller{
  private $exsists;
  private $matching;

  // public function __construct(){
  //   $this->exsists= \stdClass();
  //   $this->matching= \stdClass();
  // }

  public function run(){
    if($_SERVER['REQUEST_METHOD']==='POST'){
      $this->checkToken();
      $this->loginprocess();
    }else{
      $this->setToken();
    }
  }

  public function loginprocess(){
    //email exists
    try{
      $this->exsists=$this->userexists();
    }catch(\MyApp\Exception\noexsistsEmail $e){
      $this->setErrors('email',$e->getMessage());
    }

    //password matching
    try{
      $this->matching=$this->passMatching();
    }catch(\MyApp\Exception\unmatchingPassword $e){
      $this->setErrors('password',$e->getMessage());
    }
      
    //redirect to home
    if($this->exsists && $this->matching){
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

  public function userexists(){
    $user=new \MyApp\Model\User();
    $email=$user->emailFetch();
    if(!in_array($_POST['email'],$email)){
      throw new \MyApp\Exception\noexsistsEmail();
    }
    // $this->exsists=in_array($_POST['email'],$email)? true : false;
    return in_array($_POST['email'],$email)? true : false;
  }

  public function passMatching(){
    $user=new \MyApp\Model\User();
    $pass=$user->passFetch();
    $_pass=isset($pass->password)?$pass->password:'';
    if(!password_verify($_POST['password'],$pass->password)){
      throw new \MyApp\Exception\unmatchingPassword();
    }else{
      // $this->matching=true;
      return $this->matching=true;
    }
  } 

  

}