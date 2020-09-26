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
        elseif(IS_ROUTE){
            if(!isset($this->routes[$url]))
                return false;
            $res = $this->run_routes($url);
            return $res;
        }
        
        // var_dump($url);die;
    }

    static function get($route, $function){
        var_dump(self);
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