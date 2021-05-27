<?php
class apps extends Route
{
    protected $controller = controller_def;
    protected $method = method_def;
    protected $parameter = [];
    protected $controller_path = '';
    protected $hook;
    public function __construct()
    {
        $this->hook = new commonHook;
        if (ENV == 'DEV_ONLINE' && $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36')
            response("<p> Situs ini masih dalam proses pengembangan", 200, 'succes', 'html');


        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        if (ENV == 'DEV')
            $isrout = parent::__construct(str_replace($protocol . '/' . APP_NAME . '/', '', $this->get_link()));
        elseif (in_array(ENV, array('DEV_ONLINE', 'PROD')))
            $isrout = parent::__construct(str_replace($protocol . '/', '', $this->get_link()));

        if (!$isrout) {
            $url = $this->parseURL();
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
                    response(['message' => 'Halaman yang anda tuju tidak ditemukan', 'path' => $this->controller . '/' . $this->method], 404, 'error');
                }
            } else {
                if (!file_exists(APP_PATH . 'controller/' . $this->controller . '.php')) {
                    response(['message' => 'Halaman yang anda tuju tidak ditemukan', 'path' => $this->controller . '/' . $this->method], 404, 'error');
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

            // cek tipe akses pada method(jika ada)  dan jalankan method 
            $methods = get_class_methods($controller);

            $specific_method = [];
            $normal_method = [];

            foreach ($methods as $m) {
                $part = explode("_", $m);
                $hasil = search_part($part, ["post", "get"]);
                if ($hasil[0])
                    $specific_method[] = ["tipe" => $hasil[2], "method_name" => $m];

                else
                    $normal_method[] = $m;
            }
            if (httpmethod())
                $this->hook->formProtected($_POST);

            if (in_array($this->method, $normal_method))
                call_user_func_array([$controller, $this->method], $this->parameter);
            else {
                foreach ($specific_method as $m) {
                    if ($m['method_name'] == $this->method . "_" . $m['tipe'] && httpmethod($m['tipe'])) {
                        call_user_func_array([$controller, $this->method . "_" . $m['tipe']], $this->parameter);
                        die;
                    }
                }
                response("function " . $this->method . "_" . strtolower(get_httpmethod()) . " tidak ditemukan pada class" . $this->controller_path);
            }
        }
    }
    public function parseURL()
    {
        $url = $this->get_link();
        $url = str_replace(BASEURL, '', $url);
        return empty($url) ? $url : explode('/', $url);
    }

    public function get_link()
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $actual_link;
    }
}
