<?php

namespace MyApp\Controller;

class Index extends \MyApp\Controller {

  public function run(){
    if(isset($_SESSION['me'])){
      header('Location:'. SITE_URL . '/home.php');
    }
  }
  

}