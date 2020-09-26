<?php
class apps extends Route
{
    protected $controller = controller_def;
    protected $method = method_def;
    protected $parameter = [];
    protected $controller_path = '';
    public function __construct()
    {
        $url = $this->parseURL();
        $isrout = parent::__construct($url);
        if (!$isrout) {
            //cek apakah ada file kontroller dengan nama sesuai di url
            if (!empty($url)) {
                if (count($url) > 1 && file_exists(APP_PATH . 'controller/' . $url[0] . '/' . $url[1] . '.php')) {
                    $this->controller_path = APP_PATH . 'controller/' . $url[0] . '/' . $url[1] . '.php';
                    $this->controller = $url[1];
                    if (count($url) >= 3) {
                        $this->method = $url[2];
                        unset($url[0], $url[1], $url[2]);
                    }
                } elseif (file_exists(APP_PATH . 'controller/' . $url[0] . '.php')) {
                    $this->controller_path = APP_PATH . 'controller/' . $url[0] . '.php';
                    $this->controller = $url[0];
                    if (count($url) >= 2) {
                        $this->method = $url[1];
                        unset($url[0], $url[1]);
                    } elseif (count($url) == 1)
                        unset($url[0]);
                } else {
                    response(['message' => 'Halaman yang anda tuju tidak ditemukan'], 404, 'error');
                }
            } else {
                if (!file_exists(APP_PATH . 'controller/' . $this->controller . '.php')) {
                    response(['message' => 'Halaman yang anda tuju tidak ditemukan'], 404, 'error');
                } else {
                    $this->controller_path = APP_PATH . 'controller/' . $this->controller . '.php';
                }
            }

            require_once $this->controller_path;
            $controller = new $this->controller;
            // var_dump($this->method);die;

            //cek apakah ada parameter yang dikirimkan
            if (!empty($url)) {
                foreach ($url as $k => $v) {
                    if (empty($v))
                        unset($url[$k]);
                }

                $this->parameter = array_values($url);
            }
            //menjalankan controller, method, daan paramter
            call_user_func([$controller, $this->method], $this->parameter);
        }
    }
    public function parseURL()
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $url = str_replace(BASEURL, '', $actual_link);
        // var_dump($url);die;
        return empty($url) ? $url : explode('/', $url);
    }
}
