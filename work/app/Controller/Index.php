<?php

namespace MyApp\Controller;

class Index extends \MyApp\Controller {

  public function run(){
    if(isset($_SESSION['me'])&&$_SESSION['me']!=='guest'){
      header('Location:'. '/home.php');
    }elseif(isset($_SESSION['me'])&&$_SESSION['me']==='guest'){
      unset($_SESSION['me']);
    }

  }
  

}