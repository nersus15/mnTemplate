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
        $form = buat_form('pages/form_registrasi_full', 'bio', array('action' => 'contoh/contoh'));
        $this->add_region($form);
        $this->add_params("resource", array('main'));
        // $this->addViews('template/admin_dore', $data);
        $this->render();
    }

    function contoh_post(){
        $post = $_POST;
        var_dump($post);
    }
    function contoh_get(){
        
    }
}
