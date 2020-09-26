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
        $url_valid = '';
        $selected_routes = [];
        $sudah = false;
        // $hasil_sanitasi = $this->pisahkan_url($route);
        // var_dump($url);
        // var_dump($hasil_sanitasi);die;
        // var_dump($params);
        // var_dump($route);

        foreach ($params as $k => $v) {
            $url = explode('/', $route);
            $url_reverse = array_reverse($url);
            $url_count = count($url);
            $sisa_url = [];
            if ($v['pc'] > 0) {
                for ($i = 0; $i < $v['pc']; $i++) {
                    $sisa_url[] = $url_reverse[$i];
                    unset($url_reverse[$i]);
                }

                $url_valid = join('/', array_reverse($url_reverse));
            } else
                $url_valid = join('/', $url);


            if (isset($routes[$url_valid])) {
                return true;
                if (is_callable($routes[$url_valid])) {


                    if (!empty($sisa_url))
                        $routes[$url_valid](array_reverse($sisa_url));
                    else
                        $routes[$url_valid]();
                }
            }
        }
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
