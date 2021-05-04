<?php

spl_autoload_register(function($class){
  $prifix='MyApp\\';
  if(strpos($class,$prifix)===0){
    $className=substr($class,strlen($prifix));

    $filePath=__DIR__ . '/'. str_replace('\\','/',$className) . '.php';

    if(file_exists($filePath)){
      require $filePath;
    }
  }

});