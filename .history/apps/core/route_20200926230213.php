<?php
class Route {
    /**
     * @var
     * void
     */
    protected $routes=[];

    public function __construct($url = null) {
        if(!IS_ROUTE)
            return false;
        if(in_array($url, $this->routes))
            return $this->run_routes($url);
        extract($url);
        var_dump($0);die;
    }

    static function get($route, $function){
        $routes[] = array($route => $function);
    }

    function run_routes($route){
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