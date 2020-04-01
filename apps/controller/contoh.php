<?php
class contoh extends controller
{
    function __construct()
    {
        $auth = $this->helper('authentication');
        if ($auth->isLogin())
            redirect(BASEURL . 'user/my');
    }
    function index()
    {
        $data = array(
            'page_title' => 'My Password | Login',
            'extra_css' => array(
                ['file' => '', 'position' => 'head']
            )
        );
        $this->view('user/header/login', $data);
        $this->view('user/main/login', $data);
    }
}
