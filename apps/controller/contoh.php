<?php
class contoh extends controller
{
    function __construct()
    {
    }
    function index()
    {
        $data = array(
            'resource' => array('main', 'dore'),
            'content' => array('hello'),
            'pageName' => 'Hallo, Selamat Datang'
        );
        $this->addViews('template/admin_dore', $data);
        $this->render();
    }
}
