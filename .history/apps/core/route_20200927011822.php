<?php
class Route
{
    /**
     * @var
     * void
     */
    // protected $routes=[];
    static $params = [];
    public function __construct($url = null)
    {
        include_once APP_PATH . '/routes/routes.php';
        global $routes;
        if (!IS_ROUTE)
            return false;
        elseif (IS_ROUTE) {
            // if(!isset($routes[$url]))
            //     return false;
            // set
            $res = $this->run_routes($url);
            return $res;
        }
    }

    private static function set_params($value)
    {
        // global $params;
        self::$params[] = $value;
    }

    private function get_params($key)
    {
        return $this->params[$key];
    }

    static function get($route, $function)
    {
        global $routes;
        // sanitasi
        $r = self::pisahkan_url($route);
        $routes[$r] = $function;
    }

    // function pisahkan_url($url, $pc){

    // }

    function run_routes($route)
    {
        global $routes;
        $params = self::$params;
        $url = explode('/', $route);
        $url_count = count($url);
        $url_valid = '';
        // $hasil_sanitasi = $this->pisahkan_url($route);

        // var_dump($hasil_sanitasi);die;
        var_dump($params);
        var_dump($route);
        foreach ($params as $k => $v) {
            if ($v['pc'] > 0) {
                $url_count -= $v['pc'];
                var_dump($url_count);
                for ($i = 0; $i < $url_count; $i++)
                    unset($url[$i]);

                $url_valid = join('/', $url);
                var_dump($url_valid);
            }
        }
        // if(is_callable($routes[$route])){
        //     $routes[$route]();
        // }
        // else{
        //     $controller = explode("@", $routes[$route]);
        //     $class = '';
        //     require_once APP_PATH . 'apps/controller/' . $controller[0] . '.php';
        //     $class = new $controller[0];
        //     call_user_func_array([$class, $controller[1]], []);
        // }

        return true;
    }

    private function pisahkan_url($route)
    {
        global $true_url;
        // $url = str_replace('}', '', $route);
        $url = explode('/', $route);
        $url_length = count($url) - 1;
        $params_count = preg_match_all('/.[:]/i', $route, $result);
        $url_count = $url_length - $params_count;
        $url_valid = '';

        for ($i = 0; $i <= $url_count; $i++) {
            if ($i == 0)
                $url_valid .= $url[$i];
            else
                $url_valid .= '/' . $url[$i];
        }

        self::$params[] = ['url' => $url_valid, 'pc' => $params_count];

        return $url_valid;
    }
}
