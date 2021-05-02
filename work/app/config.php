<?php

define('DSN','mysql:host=db;dbname=poster;');
define('DB_USER','dbuser');
define('DB_PASS','aaa');
define('SITE_URL',$_SERVER['HTTP_HOST']);

define('typHeader',0);
define('typTop',1);
define('typTweet',2);

require_once(__DIR__ . '/functions.php');

require_once(__DIR__ . '/autoload.php');

session_start();

