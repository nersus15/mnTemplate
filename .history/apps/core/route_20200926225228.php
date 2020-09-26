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
            $this->run_routes();
    }

    function get($route, $function){
        $this->routes[] = array($route => $function);
    }

    function run_routes(){

    }
}