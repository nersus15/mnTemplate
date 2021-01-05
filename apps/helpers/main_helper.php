<?php

function response($message = '', $code = 200, $type = 'succes')
{
    http_response_code($code);
    $message['type'] = $type;
    echo json_encode($message);
    die;
}

function core($class = 'controller'){
    include_once APP_PATH . 'core/' . $class . '.php';
    $instance = new $class;
    return $instance;
}

function redirect($url){
    header('Location: ' . $url);
}

function config_item($file = '', $params = null)
{

    $field = [];
    if (!empty($params)) {

        if (is_array($params)) {
            for ($i = 0; $i < count($params); $i++)
                $field[] = $params[$i];
        } else
            $field[] = $params;
    }
    if (file_exists(APP_PATH . 'config/' . $file . '.php')) {
        $file_path =  APP_PATH . 'config/' . $file . '.php';
        require($file_path);

        if (!empty($field)) {
            switch (count($field)) {
                case 1:
                    return $config[$field[0]];
                    break;
                case 2:
                    return $config[$field[0]][$field[1]];
                    break;
            }
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
    return $_SERVER['REQUEST_METHOD'] == $method;
}

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
                if ($k == 'js')
                    $resourceText .= $resource['pos'] == $pos ? "<script src='{$resource['src']}'></script>" : null;
                elseif ($k == 'css')
                    $resourceText .= $resource['pos'] == $pos ? "<link rel='stylesheet' href='{$resource['src']}'></link>" : null;
            }
        }
    } else {
        if (empty($configitem[$name][$type]))
            return null;
        foreach ($configitem[$name][$type] as $k => $v) {
            $v['src'] = $v['src'];
            if ($type == 'js') {
                if ($v['pos'] == $pos)
                    $resourceText .= "<script src='{$v['src']}'></script>";
            }
            if ($type == 'css') {
                if ($v['pos'] == $pos)
                    $resourceText .= "<link rel='stylesheet' href='{$v['src']}'></link>";
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
    include APP_PATH . 'views/' . $path . '.php';
}
function rupiah_format($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}
