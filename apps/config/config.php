<?php
define("APP_NAME", 'test');
// define('PORT', 1024)
define('BASEURL', 'http://localhost/mnframework/');
define('STATIC_PATH', "https://localhost/mnframework/public/");
define("VENDOR_PATH", "https://cdn.kamscode.tech/");
define('APP_PATH', str_replace('config', '', __DIR__));
define('PROJECT_PATH', str_replace('apps/', '', APP_PATH));
define('ASSETS_PATH', str_replace('apps', '', APP_PATH) . 'public/asset/');
define('ENV', 'DEV'); // ["DEV", "PROD"]
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'test');
define('controller_def', 'contoh');
define('method_def', 'index');
define('DEF_THEME', TRUE);

define('IS_ROUTE', true);
define('DEPENDENCIES_PATH', str_replace('apps/', '', APP_PATH) . 'vendor/');
date_default_timezone_set('Asia/Singapore');

// CONST
define('MYSQL_TIMESTAMP_FORMAT', 'Y-m-d H:i:s');
define('MYSQL_DATE_FORMAT', 'Y-m-d');
define('TINY_URL', 'https://cdn.tiny.cloud/1/g3ehl5o7qpuuksdy89uuxe73fv2lmbk7d7374gxeeuts8z8w/tinymce/5/tinymce.min.js');
