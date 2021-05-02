<?php

namespace MyApp\Exception;

class unmatchingPassword extends \Exception {
  public $message='パスワードが違います。';
}