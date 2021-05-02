<?php

namespace MyApp\Exception;

class duplicateEmail extends \Exception{
  public $message='そのメールアドレスは既に使用されています。';
}