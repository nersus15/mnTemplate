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
            if(!isset($routes[$url]))
                return false;
            $res = $this->run_routes($url);
            return $res;
        }
        
        // var_dump($url);die;
    }

    static function get($route, $function){
        global $routes;

        // sanitasi
        self::sanitasi_route($route);
        $routes[$route] = $function;
    }

    function run_routes($route){
        global $routes;
        if(is_callable($routes[$route])){
            var_dump($routes[$route]);
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

    private function sanitasi_route($route){
        $url = str_replace('}', '', $route);
        $url = explode('/{', $route);
        
        var_dump($url);
    }
}