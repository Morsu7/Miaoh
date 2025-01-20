<?php
define('SITE_NAME', 'MIAOH');
//App Root
define('APP_ROOT', dirname(dirname(__FILE__)));
define('URL_ROOT', '/');
define('URL_SUBFOLDER', '');
//DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'miaoh_db');

define('IMAGE_PATH', 'public/assets/images/');

define('SHIPPING_ADDRESS', '47522 Cesena FC');

$show_header = true;

//Load Config
include("connection.php");

if(session_status() === PHP_SESSION_NONE) session_start();