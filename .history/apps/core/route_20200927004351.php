<?php
class Route {
    /**
     * @var
     * void
     */
    // protected $routes=[];

    public function __construct($url = null) {
        include_once APP_PATH . '/routes/routes.php';
        global $routes;
        if(!IS_ROUTE)
            return false;
        elseif(IS_ROUTE){
            // if(!isset($routes[$url]))
            //     return false;
            $res = $this->run_routes($url);
            return $res;
        }
        
    }

    static function get($route, $function){
        global $routes;
        // sanitasi
        $r = self::pisahkan_url($route);
        $routes[$route] = $function;
    }

    // function pisahkan_url($url, $pc){

    // }

    function run_routes($route){
        global $routes;
        // $url = explode('/', $route);

        // $hasil_sanitasi = $this->pisahkan_url($route);

        // var_dump($hasil_sanitasi);die;
        print_r($routes);

        if(is_callable($routes[$route])){
            $routes[$route]();
        }
        else{
            $controller = explode("@", $routes[$route]);
            $class = '';
            require_once APP_PATH . 'apps/controller/' . $controller[0] . '.php';
            $class = new $controller[0];
            call_user_func_array([$class, $controller[1]], []);
        }

        return true;
    }

    private function pisahkan_url($route){
        // $url = str_replace('}', '', $route);
        $url = explode('/', $route);
        $url_length = count($url) - 1;
        $params_count = preg_match_all('/.[:]/i', $route, $result);
        $url_count = $url_length - $params_count;
        $url_valid = '';

        for ($i=0; $i <= $url_count; $i++) { 
            if($i == 0)
                $url_valid .= $url[$i];
            else
                $url_valid .= '/' . $url[$i];
        }
        return ['url' => $url_valid, 'uc' => $url_count, 'pc' => $params_count, 'route' =>  $route];
    }
}