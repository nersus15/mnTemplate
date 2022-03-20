<?php

/**
 * Tipe Hooks
 * sebelum muat constructor controller => before_construct
 * sebelum muat controller => before_controller
 * setelah muat controller => after_controller
 * setelah muat view => after_render
 * 
 * Parameter
 * nama file hooks => fpath
 * nama class => class
 * function => method
 * 
 * atau jika prosedural
 * function yang akan dieksekusi => func
 * 
 * untuk url yang spesifik tambahkan url => url
 * 
 * ex: $config['hooks'][tipe hooks] = array()
 */

 $config['hooks'] = array(
    'before_controller' => array(
        'fpath' => 'handle_halaman',
        'class' => 'HandleHalaman',
        'method' => 'siapkan_halaman',
    )
 );