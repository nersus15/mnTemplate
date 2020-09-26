<?php
define('BASEURL', 'https://domain.com/');
define('STATIC_PATH', "https://domain.com/public/");
define("VENDOR_PATH", "https://cdn.kamscode.tech/");
define('APP_PATH', str_replace('config', '', __DIR__));
define('PROJECT_PATH', str_replace('apps/', '', APP_PATH));
define('DB_HOST', 'host database');
define('DB_USER', 'username db');
define('DB_PASS', 'password db');
define('DB_NAME', 'database name');
define('controller_def', 'default controller');
define('method_def', 'default method');
define('IS_ROUTE', false);
define('DEPENDENCIES_PATH', str_replace('apps/', '', APP_PATH) . 'vendor/');
date_default_timezone_set('Asia/Singapore');

// CONST
define('MYSQL_TIMESTAMP_FORMAT', 'Y-m-d H:i:s');
define('MYSQL_DATE_FORMAT', 'Y-m-d');
