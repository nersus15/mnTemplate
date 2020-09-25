<?php
define('BASEURL', 'https://hipelmas.kamscode.tech/');
define('STATIC_PATH', "https://hipelmas.kamscode.tech/public/");
define("VENDOR_PATH", "https://cdn.kamscode.tech/");
define('APP_PATH', str_replace('config', '', __DIR__));
define('PROJECT_PATH', str_replace('apps/', '', APP_PATH));
define('DB_HOST', 'kamscode.tech');
define('DB_USER', 'kamscode');
define('DB_PASS', '3bS9Fn2g8n');
define('DB_NAME', 'kamscode_hipelmas');
define('controller_def', 'home');
define('method_def', 'index');
define('IS_ROUTE', false);
define('DEPENDENCIES_PATH', str_replace('apps/', '', APP_PATH) . 'vendor/');
date_default_timezone_set('Asia/Singapore');

// CONST
define('MYSQL_TIMESTAMP_FORMAT', 'Y-m-d H:i:s');
define('MYSQL_DATE_FORMAT', 'Y-m-d');