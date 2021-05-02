<?php

namespace MyApp\Exception;

class noexsistsEmail extends \Exception {
  public $message='そのメールアドレスは登録されていません';
}