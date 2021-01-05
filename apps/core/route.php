<?php
class Route
{
    // protected $routes=[];
    static $params = [];
    public function __construct($url = null)
    {
        $request = explode('/', $url);
        $lastIndex = array_key_last($request);
        if ($request[$lastIndex] == '')
            unset($request[$lastIndex]);
        $url = join('/', $request);

        if (!IS_ROUTE)
            return false;
        elseif (IS_ROUTE) {
            include_once APP_PATH . 'routes/routes.php';
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
        $r = self::pisahkan_url($route, 'GET');
        $routes[$r . ':GET'] = $function;
    }

    static function post($route, $function)
    {
        global $routes;

        // sanitasi
        $r = self::pisahkan_url($route, 'POST');
        $routes[$r . ':POST'] = $function;
    }

    // function pisahkan_url($url, $pc){

    // }
    function need_params($func)
    {
        $reflection = new ReflectionFunction($func);

        return $reflection->getNumberOfParameters();
    }
    function run_routes($route)
    {
        global $routes;
        $params = self::$params;
        $url_valid = '';
        $selected_routes = [];
        $sudah = false;
        $ketemu = FALSE;

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

            if (isset($routes[$url_valid . ':' . $v['http_method']]) && httpmethod($v['http_method'])) {
                if (is_callable($routes[$url_valid . ':' . $v['http_method']])) {
                    if ($this->need_params($routes[$url_valid . ':' . $v['http_method']]) > 0)
                        $routes[$url_valid . ':' . $v['http_method']](array_reverse($sisa_url));
                    else
                        $routes[$url_valid]();
                } elseif (!is_array($routes[$url_valid . ':' . $v['http_method']])) {
                    $route = explode('@', $routes[$url_valid . ':' . $v['http_method']]);
                    $controller_path = APP_PATH . 'controller/' . strtolower($route[0]) . '.php';
                    $registered_controller_path = APP_PATH . 'controller/' . strtolower($route[0]) . '.php';
                    if (is_file($controller_path))
                        require_once $controller_path;
                    else {
                        $controller_path = 'controller/' . str_replace($route[0][0], strtoupper($route[0][0]), $route[0]) . '.php';
                        if (is_file($controller_path))
                            require_once $controller_path;
                        else
                            response(['message' => 'File Controller yang didaftarkan pada route tidak ditemukan ', 'path ' =>  $registered_controller_path]);
                    }

                    $segments_of_url = explode('/', $route[0]);
                    if (class_exists($segments_of_url[array_key_last($segments_of_url)]))
                        $controller = new $segments_of_url[array_key_last($segments_of_url)];
                    else
                        response(['message' => 'Tidak ada class dengan nama "' . $segments_of_url[array_key_last($segments_of_url)] . '" pada controller', 'path' => $registered_controller_path]);

                    if (method_exists($controller, $route[1]))
                        $method = $route[1];
                    else
                        response(['message' => 'Tidak ada method dengan nama "' . $route[1] . '" pada controller ', 'path' => $registered_controller_path]);
                    if (empty($sisa_url))
                        $sisa_url = [];

                    call_user_func([$controller, $method], $sisa_url);
                }
                $ketemu = TRUE;
            }
        }
        return $ketemu;
    }

    private static function pisahkan_url($route, $http_method)
    {
        // global $true_url;
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

        self::$params[] = ['url' => $url_valid, 'pc' => $params_count, 'http_method' => $http_method];

        return $url_valid;
    }
}
