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

    protected static function get($route, $function){
        var_dump($routes);
        // $this->routes[] = array($route => $function);
    }

    function run_routes($route){
        var_dump($route);
        if(is_callable($this->routes[$route]))
            $this->routes[$route];
        else{
            $controller = explode("@", $this->routes[$route]);
            $class = '';
            require_once APP_PATH . 'apps/controller/' . $controller[0] . '.php';
            $class = new $controller[0];
            call_user_func_array([$class, $controller[1]], []);
        }

        return true;
    }
}