<?php

namespace MyApp;

class Model{
  public $_db;

  public function __construct(){
    try{
      $this->_db= new \pdo(DSN,DB_USER,DB_PASS);
    }catch(\PDOException $e){
      echo $e->getMessage();
    }
  }
}