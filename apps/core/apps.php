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
            list($clz, $mtd) = $this->cek_hook();
            if (!empty($url) && count($url) >= 2 && httpmethod('GET')) {
                $last = count($url) - 1;
                if (stristr($url[$last], '?')) {
                    $segments = explode('?', $url[$last]);
                    if (count($segments) != 2)
                        return;
                    $url[$last] = $segments[0];

                    foreach (explode('&', $segments[1]) as $get) {
                        $key_value = explode("=", $get);
                        $_GET[$key_value[0]] = $key_value[1];
                    }
                }
                unset($_GET['url']);

            }
            if (!empty($url)) {
                if (count($url) > 1 && file_exists(APP_PATH . 'controller' . DIRECTORY_SEPARATOR . convert_path($url[0]) . DIRECTORY_SEPARATOR . $url[1] . '.php')) {
                    $this->controller_path = APP_PATH . 'controller' . DIRECTORY_SEPARATOR . convert_path($url[0]) . DIRECTORY_SEPARATOR . $url[1] . '.php';
                    $this->controller = $url[1];
                    if (count($url) >= 3) {
                        $this->method = $url[2];
                        unset($url[0], $url[1], $url[2]);
                    }
                } elseif (file_exists(APP_PATH . 'controller' . DIRECTORY_SEPARATOR . convert_path($url[0]) . '.php')) {
                    $this->controller_path = APP_PATH . 'controller' . DIRECTORY_SEPARATOR . convert_path($url[0]) . '.php';
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
                if (!file_exists(APP_PATH . 'controller' . DIRECTORY_SEPARATOR . convert_path($this->controller). '.php')) {
                    response(['message' => 'Halaman yang anda tuju tidak ditemukan', 'path' => $this->controller . '/' . $this->method], 404, 'error');
                } else {
                    $this->controller_path = APP_PATH . 'controller' . DIRECTORY_SEPARATOR . convert_path($this->controller) . '.php';
                }
            }

            foreach($clz as $k => $h){
                if($k == 'before_construct')
                    call_user_func_array($h['class'], $h['method'], []);
            }
            foreach($mtd as $k => $h){
                if($k == 'before_construct')
                    $h();
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

            if (in_array($this->method, $normal_method)){
                foreach($clz as $k => $h){
                    if($k == 'before_controller')
                        call_user_func_array($h['class'], $h['method'], []);
                }
                foreach($mtd as $k => $h){
                    if($k == 'before_controller')
                        $h();
                }
                call_user_func_array([$controller, $this->method], $this->parameter);
                foreach($clz as $k => $h){
                    if($k == 'after_controller')
                        call_user_func_array($h['class'], $h['method'], []);
                }
                foreach($mtd as $k => $h){
                    if($k == 'after_controller')
                        $h();
                }
            }else {
                foreach ($specific_method as $m) {
                    if ($m['method_name'] == $this->method . "_" . $m['tipe'] && httpmethod($m['tipe'])) {
                        if (httpmethod())
                            $this->hook->formProtected($_POST);
                        foreach($clz as $k => $h){
                            if($k == 'before_controller')
                                call_user_func_array($h['class'], $h['method'], []);
                        }
                        foreach($mtd as $k => $h){
                            if($k == 'before_controller')
                                $h();
                        }
                        call_user_func_array([$controller, $this->method . "_" . $m['tipe']], $this->parameter);
                        foreach($clz as $k => $h){
                            if($k == 'after_construct')
                                call_user_func_array($h['class'], $h['method'], []);
                        }
                        foreach($mtd as $k => $h){
                            if($k == 'after_controller')
                                $h();
                        }
                        die;
                    }
                }
                response("function " . $this->method . "_" . strtolower(get_httpmethod()) . " tidak ditemukan pada class " . $this->controller_path, 500);
            }
        }
    }
    public function parseURL($segmen = true)
    {
        $url = $this->get_link();
        $url = str_replace(BASEURL, '', $url);
        if($segmen)
            return empty($url) ? $url : explode('/', $url);
        else
            return $url;
    }

    public function get_link()
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $actual_link;
    }

    private function cek_hook(){
        $hooks = config_item('hooks', 'hooks');
        $clz = new stdClass();
        $mtd = new stdClass();
        if(!empty($hooks)){
            foreach ($hooks as $k => $v){
               if(in_array($k, ['before_construct', 'before_controller', 'after_controller'])){
                   if(isset($v['url'])){
                        $url = $this->parseURL(false);
                        if(empty($url)) $url = '/';

                        if($v['url'] == $url){
                           if(isset($v['class'])){
                                require_once convert_path(APP_PATH . 'hooks/' . $v['fpath'] . '.php'); 
                                $tmp = new $v['class'];
                                $clz->{$k} = [
                                    'class' => $tmp,
                                    'method' => $v['method'],
                                    'hooks' => $v
                                ];
                            }else{
                                $mtd->{$k} = $v['func'];
                            }
                        }
                   }else{
                    if(isset($v['class'])){
                        require_once convert_path(APP_PATH . 'hooks/' . $v['fpath'] . '.php'); 
                        $tmp = new $v['class'];
                        $clz->{$k} = [
                            'class' => $tmp,
                            'method' => $v['method'],
                            'hooks' => $v
                        ];
                    }else{
                        $mtd->{$k} = $v['func'];
                    }
                   }
               }
            }
        }
        return [$clz, $mtd];
    }
}
