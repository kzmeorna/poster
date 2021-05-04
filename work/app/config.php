<?php

// define('DSN','mysql:host=db;dbname=poster;');
// define('DB_USER','dbuser');
// define('DB_PASS','aaa');
define('DSN','mysql:host=us-cdbr-east-03.cleardb.com;dbname=heroku_10f021bf95dbf6a;');
define('DB_USER','bbdcc631f11780');
define('DB_PASS','7b29316a');
define('SITE_URL',$_SERVER['HTTP_HOST']);

define('typHeader',0);
define('typTop',1);
define('typTweet',2);

require_once(__DIR__ . '/functions.php');

require_once(__DIR__ . '/autoload.php');

session_start();

