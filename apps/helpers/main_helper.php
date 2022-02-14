<?php

function response($message = '', $code = 200, $type = 'succes', $format = 'json')
{
    http_response_code($code);
    $responsse = array();
    if ($code != 200)
        $type = 'Error';

    if (is_string($message))
        $responsse['message'] = $message;
    else
        $responsse = $message;

    if (!isset($message['type']))
        $responsse['type'] = $type;
    else
        $responsse['type'] = $message['type'];
    if ($format == 'json')
        echo json_encode($responsse);
    elseif ($format == 'html') {
        echo '<script> var path = "' . BASEURL . '"</script>';
        echo $responsse['message'];
    }
    die;
}

function macAddress($return = false)
{;
}
function core($class = 'controller')
{
    include_once APP_PATH . 'core' . DIRECTORY_SEPARATOR . $class . '.php';
    $instance = new $class;
    return $instance;
}

function redirect($url)
{
    header('Location: ' . $url);
}

function config_item($file = '', $params = null)
{

    $index = '';
    if (!empty($params)) {
        if (is_array($params)) {
            foreach ($params as $value)
                $index = $index . "['" . $value . "']";
        } else
            $index = "['$params']";
    }
    if (file_exists(APP_PATH . 'config'. DIRECTORY_SEPARATOR . convert_path($file) . '.php')) {
        $file_path =  APP_PATH . 'config' . DIRECTORY_SEPARATOR . convert_path($file) . '.php';
        require($file_path);
        if (!empty($params)) {
            $str = '$configItem = $config' . $index . ';';
            eval($str);
            return $configItem;
        } else
            return $config;
    } else
        response(['message' => 'file config tidak ditemukan'], 500);
}
function catat($log, $tipe = 'WARNING')
{
    $temp = $log;
    $separator = "============================================================<< MULAI >>=====================================================";

    $temp = is_array($temp) ? print_r($temp, true)  : $temp;
    $log = PHP_EOL . $separator . PHP_EOL . "[" . waktu(null, 'd-M-Y H:i:s') . " " . date_default_timezone_get() . ' ' . get_client_ip() . ' ' . $_SERVER['HTTP_USER_AGENT'] . "] " . $tipe . ": " . $temp;

    $log_sebelum = file_get_contents(PROJECT_PATH . 'error_log');
    $separator = "============================================================<< SELESAI >>=====================================================";
    file_put_contents(PROJECT_PATH . 'error_log', $log_sebelum . PHP_EOL . $log . PHP_EOL . $separator . PHP_EOL);
}

function clear_log()
{
    file_put_contents(PROJECT_PATH . 'error_log', '');
}
// Function to get the client IP address
function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
function random($length = 5, $type = 'string')
{
    $characters = $type == 'string' ? '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' : '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $type == 'string' ? $randomString : boolval($randomString);
}
function waktu($waktu = null, $format = MYSQL_TIMESTAMP_FORMAT)
{
    $waktu = empty($waktu) ? time() : $waktu;
    return date($format, $waktu);
}
function httpmethod($method = 'POST')
{
    $method = strtoupper($method);
    return $_SERVER['REQUEST_METHOD'] == $method;
}

function get_httpmethod(){
    return $_SERVER['REQUEST_METHOD'];
}
function sessiondata($index = 'login', $kolom = null)
{

    $data = get_userdata($index);
    return empty($kolom) ? $data : (isset($data[$kolom]) ? $data[$kolom] : null);
}

function set_userdata($key, $value)
{
    $_SESSION['user_data'][$key] = $value;
}
function add_userdatavalue($key, $value){
    if (isset($_SESSION['user_data'][$key])){
        if(is_array($_SESSION['user_data'][$key]))
            $_SESSION['user_data'][$key][] = $value;
    }else{
        $_SESSION['user_data'][$key] = array($value);
    }
}

function unset_userdata($key)
{
    unset($_SESSION['user_data'][$key]);
}

function get_userdata($key)
{
    if (isset($_SESSION['user_data'][$key]))
        return $_SESSION['user_data'][$key];
    else
        return NULL;
}

function base_url($path = null)
{
    return empty($path) ? BASEURL : BASEURL . $path;
}

function config_sidebar($sidebar = null, int $activeMenu = 0, $subMenu = 0)
{
    if (is_null($sidebar))
        return config_item('component');

    $config = config_item('component', array('component', 'sidebar', 'dore', $sidebar));

    $config['menus'][$activeMenu]['active'] = true;
    $induk = $config['menus'][$activeMenu]['link'];
    if ($induk[0] != '#')
        return $config;
    else {
        $sub = null;
        $induk = str_replace('#', '', $induk);
        foreach ($config['subMenus'] as $key => $value) {
            if ($value['induk'] == $induk) {
                $sub = $key;
                continue;
            }
        }
        if (!is_null($sub))
            $config['subMenus'][$sub]['menus'][$subMenu]['active'] = true;

        return $config;
    }
}

// TODO: BUAT HELPER DIBAWAH INI
// function component_config($config = 'sidebar', $group = 'dore'){

// }
function add_resource_group($name, $type = null, $pos = null)
{

    $type = empty($type) ? 'semua' : $type;
    $pos = empty($pos) ? 'head' : $pos;


    $resourceText = '';
    $configitem = config_item('theme');
    $configitem = $configitem['themes'];

    if ($type == 'semua') {
        if (empty($configitem[$name]))
            return null;
        foreach ($configitem[$name] as $k => $v) {
            foreach ($v as $resource) {
                $resource['src'] = $resource['src'];
                if ($k == 'js') {
                    if (isset($resource['type']) && $resource['type'] == 'inline')
                        $resourceText .= $resource['pos'] == $pos ? "<script>" . $resource['src'] . "</script>" : null;
                    else
                        $resourceText .= $resource['pos'] == $pos ? "<script src='{$resource['src']}'></script>" : null;
                } elseif ($k == 'css') {
                    if (isset($resource['type']) && $resource['type'] == 'inline')
                        $resourceText .= $resource['pos'] == $pos ? "<style>" . $resource['src'] . "</style>" : null;
                    else
                        $resourceText .= $resource['pos'] == $pos ? "<link rel='stylesheet' href='{$resource['src']}'></link>" : null;
                }
            }
        }
    } else {
        if (empty($configitem[$name][$type]))
            return null;
        foreach ($configitem[$name][$type] as $k => $v) {
            $v['src'] = $v['src'];
            if ($type == 'js') {
                if (isset($resource['type']) && $resource['type'] == 'inline')
                    $resourceText .= $v['pos'] == $pos ? "<script>" . $v['src'] . "</script>" : null;
                else
                    $resourceText .= $v['pos'] == $pos ? "<script src='{$v['src']}'></script>" : null;
            } elseif ($type == 'css') {
                if (isset($v['type']) && $v['type'] == 'inline')
                    $resourceText .= $v['pos'] == $pos ? "<style>" . $v['src'] . "</style>" : null;
                else
                    $resourceText .= $v['pos'] == $pos ? "<link rel='stylesheet' href='{$v['src']}'></link>" : null;
            }
        }
    }
    return $resourceText;
}

function include_view($path, $data = null)
{
    if (is_array($data))
        extract($data);
    // var_dump(APP_PATH . 'views/' . $path . '.php');die;
    include APP_PATH . 'views' . DIRECTORY_SEPARATOR . convert_path($path) . '.php';
}
function rupiah_format($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function search_part($arr, $search, $callback = null){
    $data = [false, -1, ""];
    
    foreach($arr as $key => $value){
        if(is_array($search)){
          if(in_array($value, $search))
            $data = [true, $key, $value];
        }else{
          if($value == $search)
            $data = [true, $key, $value];
        }
     }
     
    if(!empty($callback) && is_callable($callback))
        $callback();
     else
       return $data;
    
  }
  
  function search_part_bool($arr, $search, $callback = null){
    $data = -1;
    
    foreach($arr as $key => $value){
      if(is_array($search)){
          if(in_array($value, $search))
            $data = $key;
        }else{
          if($value == $search)
            $data = $key;
        }
     }
     
     if(!empty($callback) && is_callable($callback))
        $callback();
     else
       return $data != -1;
    
  }

  function get_path($path = null, $type = 'view'){
    $path = empty($path) ? '.' : $path;
    $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
    return APP_PATH . $path;
  }

  function convert_path($path){
    return DIRECTORY_SEPARATOR == "\\" ? str_replace("/", "\\", $path) : $path;
  }