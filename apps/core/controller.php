<?php
class controller
{

    private $instance;
    private $views = [];
    private $params = ['params' => []];

    public function __construct()
    {
        $this->instance = &$this;
    }
    public function view($view, $data = [])
    {
        extract($data);
        // var_dump(APP_PATH . 'views/' . $view . '.php');die;
        try {
            require_once APP_PATH . 'views/' . $view . '.php';
        } catch (\Throwable $th) {
            response(['message' => 'error', 'err' => print_r($th, true)], 404);
        }
    }
    public function model($model)
    {
        require_once APP_PATH . 'models/' . $model . '.php';
        return new $model;
    }
    public function helper($helper)
    {
        require_once APP_PATH . 'helpers/' . $helper . '.php';
    }

    public function library($lib)
    {
        require_once APP_PATH . 'library/' . $lib . '.php';
        $class = $lib . '_lib';
        return new $class;
    }
    public function getinstance()
    {
        return $this->instance;
    }

    public function addViews($views, $params = null)
    {
        if (is_array($views)) {
            foreach ($views as $v)
                $this->views[] = $v;
        } else
            $this->views[] = $views;
        if (!is_array($params))
            $this->params['params'][] = $params;
        else {
            foreach ($params as $k => $v) {
                $this->params[$k] = $v;
            }
        }
    }
    function add_javascript($js)
    {
        if (isset($js['pos'])) {
            $this->params['extra_js'][] = $js;
        } else {
            foreach ($js as $j) {
                $this->params['extra_js'][] = $j;
            }
        }
    }
    function error_page($file, $params, $type = 'html')
    {
        $this->load->view('errors/' . $type . '/' . $file, $params);
    }
    function add_cachedJavascript($js, $type = 'file', $data = array())
    {
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $this->params['var'][$k] = $v;
            }
        }
        $this->params['extra_js'][] = array(
            'script' => $type == 'file' ? file_get_contents(STATIC_PATH . 'js/' . $js . '.js') : $js,
            'type' => 'inline',
            'pos' => 'body:end'
        );
    }
    function add_cachedStylesheet($css, $type = 'file', $pos = 'head', $data = array())
    {
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $this->params['var'][$k] = $v;
            }
        }
        $this->params['extra_css'][] = array(
            'style' => $type == 'file' ? file_get_contents(STATIC_PATH  . 'css/' . $css . '.css') : $css,
            'type' => 'inline',
            'pos' => $pos
        );
    }
    function add_stylesheet($css)
    {
        if (isset($css['pos'])) {
            $this->params['extra_css'][] = $css;
        } else {
            foreach ($css as $c) {
                $this->params['extra_css'][] = $c;
            }
        }
    }
    public function render()
    {
        foreach ($this->views as $view) {
            $this->view($view, $this->params);
        }
        $this->views = [];
        $this->params = [];
    }
}
