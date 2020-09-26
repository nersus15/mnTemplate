<?php
define("APP_NAME", 'mnframework');
define('BASEURL', 'http://localhost/mnframework/');
// define('STATIC_PATH', "https://localhost/mnframework/");
define("VENDOR_PATH", "https://cdn.kamscode.tech/");
define('APP_PATH', str_replace('config', '', __DIR__));
define('PROJECT_PATH', str_replace('apps/', '', APP_PATH));
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'mnframework');
define('controller_def', 'home');
define('method_def', 'index');
define('IS_ROUTE', true);
define('DEPENDENCIES_PATH', str_replace('apps/', '', APP_PATH) . 'vendor/');
date_default_timezone_set('Asia/Singapore');

// CONST
define('MYSQL_TIMESTAMP_FORMAT', 'Y-m-d H:i:s');
define('MYSQL_DATE_FORMAT', 'Y-m-d');
