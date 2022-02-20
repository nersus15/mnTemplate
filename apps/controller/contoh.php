<?php
class contoh extends controller
{
    function __construct()
    {
    }
    function index()
    {
        $this->helper('forms_helper');
        $data = array(
            'pageName' => 'Registrasi Publik',
            'resource' => array('main', 'landing'),
            'navbar' => 'compui/navbar/dore.navbar-client',
            'navbarMobile' => 'compui/navbar/dore.navbar-client-mobile',
            'loadingAnim' => true,
            'data_content' => array(
            )
        );
        $this->add_stylesheet(array(
            ['pos' => 'head', 'src' => STATIC_PATH . 'css/landing-page.css', 'type' => 'file'],
            ['pos' => 'head', 'src' => STATIC_PATH . 'fonts/material-design-iconic-font/css/material-design-iconic-font.css', 'type' => 'file'],
            ['pos' => 'head', 'src' => STATIC_PATH . 'css/form-wizard.css', 'type' => 'file'],
            ['pos' => 'head', 'src' => VENDOR_PATH . 'datepicker/css/datepicker.css', 'type' => 'file']
        ));

        // $this->add_cachedJavascript('register-public');

        $this->add_javascript(array(
            ['pos' => 'body:end', 'src' => VENDOR_PATH . 'jquery/jquery.steps.js', 'type' => 'file'],

            
            ['pos' => 'head', 'src' => VENDOR_PATH . 'datepicker/js/bootstrap-datepicker.js', 'type' => 'file'],
            ['pos' => 'body:end', 'src' => STATIC_PATH . 'js/form-wizard.js', 'type' => 'file']
        ));
        $form = buat_form('pages/form_registrasi_full', 'form-registrasi-full', base_url('contoh/contoh'));
        $this->add_region($form);
        $this->addViews('template/form_registrasi_dore', $data);
        $this->render();
    }

    function contoh_post(){
        $post = $_POST;
        $default = array(
            'contoh' => 'Ini nilai default'
        );
        $peta = array(
            'hp' => array(
                '083142808426' => 'ini peta nilai'
            )
        );
        $input = fieldmapping($post, 'contoh', $default, $peta);
        response($input);
    }
    function contoh_get(){
        
    }
}
