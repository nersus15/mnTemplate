<?php
    $routes = [];
    $true_url = '';
    // contoh penggunaan route, route bisa dimatikan di config
    Route::get('admin/home/:ad', function ($params) {
        $controller =& core();
        $data = array(
            'resource' => array('main', 'dore'),
            'content' => array('hello'),
            'pageName' => 'Hallo, Selamat Datang'
        );
        $controller->addViews('template/admin_dore', $data);
        $controller->render();
    });