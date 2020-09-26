<?php
    $routes = [];
    $true_url = '';
    Route::get('admin/home/:ad', function ($params) {
        var_dump($params);
    });

    Route::get('home/admin/:ad/:id', function ($id) {
        
    });