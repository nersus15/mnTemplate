<?php
require_once 'config/config.php';
require_once 'core/route.php';

if (IS_ROUTE)
    include 'routes/routes.php';

require_once 'core/apps.php';
require_once 'core/controller.php';
require_once 'core/database.php';
require_once 'core/flasher.php';
require_once 'config/autoload.php';

if(JWT_AUTH || SECURE_FORM)
    require_once 'core/token_generator.php';
    
foreach ($config['autoload'] as $k => $v) {
    if (!empty($config['autoload'][$k])) {
        foreach ($config['autoload'][$k] as $a) {
            require_once $k . '/' . $a . '.php';
        }
    }
}

if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
