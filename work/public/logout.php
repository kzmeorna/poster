<?php

require_once(__DIR__ . '/../app/config.php');

if(isset($_COOKIE["PHPSESSID"])){
  setcookie('PHPSESSID','',time()-1800,'/');
}

session_destroy();

header('Location:'.'http://' . SITE_URL . '/index.php');