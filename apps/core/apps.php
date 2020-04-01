<?php
class apps
{
    protected $controller = controller_def;
    protected $method = method_def;
    protected $parameter = [];
    public function __construct()
    {
        $this->globalFunction();
        $url = $this->parseURL();
        //cek apakah ada file kontroller dengan nama sesuai di url
        if (file_exists('apps/controller/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        } elseif ($url[0] == 'ws' && file_exists('apps/controller/ws/' . $url[1] . '.php')) {
            $this->controller = $url[1];
            unset($url[0]);
            unset($url[1]);
            $url[1] = $url[2];
            $web_service = true;
            require_once 'apps/controller/ws/' . $this->controller . '.php';
        }
        // var_dump($url);
        if (!isset($web_service))
            require_once 'apps/controller/' . $this->controller . '.php';

        $this->controller = new $this->controller;


        //cek apakah ada file method dengan nama sesuai di url
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        //cek apakah ada parameter yang dikirimkan
        if (!empty($url)) {
            $this->parameter = array_values($url);
        }

        //menjalankan controller, method, daan paramter
        call_user_func([$this->controller, $this->method], $this->parameter);
    }
    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
    public function globalFunction()
    {
        function redirect($url)
        {
            header("Location: " . $url);
        }
    }
}
