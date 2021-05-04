<?php

namespace MyApp\Controller;

class Idname extends \MyApp\Controller{
  private $res;

  public function run(){ 
    if($_SERVER['REQUEST_METHOD']==='POST'){
      $this->checkToken();
      $this->registerIdName();
    }else{
      $this->setToken();
    }
  }

  public function registerIdName(){
    // insert to db

    $idname=new \MyApp\Model\User;
    if(isset($_POST['name'])&&isset($_POST['userId'])){
      $this->res=$idname->insertIdName();
    }

    //redirect to home
    if($this->res){
      header('Location:'.'http://'. SITE_URL .'/home.php');
    }
  }
}