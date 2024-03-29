<?php
$secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
// APP_NAME harus sama dengan nama folder project (karena itu akan berpengaruh pada routing), misal nama project adalah penjualanEs maka APP_NAME harus diganti dari template ke penjualanES
define("APP_NAME", 'mnTemplateTest');

// Aktifkan DOMAIN_NAME dan masukkan nama domain ketika ENV di set ke PROD atau DEV_ONLINE, jika tidak maka akan terjadi error
define('DOMAIN_NAME', '');
define('ENV', 'DEV'); // ["DEV", "PROD", "DEV_ONLINE"]
define('PORT', 8080);
define("VENDOR_PATH", "https://cdn.kamscodelab.tech/");
define('APP_PATH', str_replace('config', '', __DIR__));
define('PROJECT_PATH', str_replace('apps' . DIRECTORY_SEPARATOR, '', APP_PATH));
define('ASSETS_PATH', str_replace('apps' . DIRECTORY_SEPARATOR, '', APP_PATH) . 'public'. DIRECTORY_SEPARATOR .'assets'. DIRECTORY_SEPARATOR);
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ada');
define('controller_def', 'contoh');
define('method_def', 'index');
define('DEF_THEME', TRUE);
define("JWT_AUTH", true);
define("SYNC_DATAUSER", FALSE);
define('IS_ROUTE', true);
define('DEPENDENCIES_PATH', str_replace('apps' . DIRECTORY_SEPARATOR, '', APP_PATH) . 'vendor' . DIRECTORY_SEPARATOR);
date_default_timezone_set('Asia/Singapore');
define("DEBUG_MODE", true);
define("SECURE_FORM", true); // if true, form must create with buat_form() to add token validation
// CONST
define('MYSQL_TIMESTAMP_FORMAT', 'Y-m-d H:i:s');
define('MYSQL_DATE_FORMAT', 'Y-m-d');
define('TINY_URL', 'https://cdn.tiny.cloud/1/g3ehl5o7qpuuksdy89uuxe73fv2lmbk7d7374gxeeuts8z8w/tinymce/5/tinymce.min.js');


if(ENV == 'DEV'){
    if(defined("PORT") && !empty(PORT))
        define('BASEURL', $secure ? 'https://localhost:'.PORT.'/'. APP_NAME .'/' : 'http://localhost:'.PORT.'/'. APP_NAME .'/');
    else
        define('BASEURL', $secure ? 'https://localhost/'. APP_NAME .'/' : 'http://localhost/'. APP_NAME .'/');
}else
    define('BASEURL', $secure ? 'https://'. DOMAIN_NAME .'/' : 'http://'. DOMAIN_NAME .'/');

define('STATIC_PATH', BASEURL . 'public/');
if(ENV != "DEV" && empty(DOMAIN_NAME))
    die("Anda Mengatur ENV menjadi " . ENV . " tapi tidak memasukkan DOMAIN_NAME di config/cofig.php");
