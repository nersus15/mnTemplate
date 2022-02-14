<?php
class controller
{

    private $instance;
    private $views = [];
    private $params = ['params' => []];
    private $region = [];
    public $db;
    public function __construct()
    {
        $this->instance =& $this;
        if(class_exists('qbuilder'))
            $this->db = new qbuilder();
        else{
            require_once "../helpers/qbuilder.php";
            $this->db = new qbuilder();
        }
    }
    public function view($view, $data = [])
    {
        extract($data);
        // var_dump(APP_PATH . 'views/' . $view . '.php');die;
        try {
            require_once APP_PATH . 'views' . DIRECTORY_SEPARATOR . convert_path($view). '.php';
        } catch (\Throwable $th) {
            response(['message' => 'error', 'err' => print_r($th, true)], 404);
        }
    }
    public function model($model, $prefixs = null)
    {
        require_once APP_PATH . 'models' . DIRECTORY_SEPARATOR . convert_path($model) . '.php';
        $class = $lib . $prefixs;
        $model = new $class();
        $this->{$lib} = $model;
    }
    public function helper($helper)
    {
        require_once APP_PATH . 'helpers' . DIRECTORY_SEPARATOR . convert_path($helper) . '.php';
    }

    public function library($lib)
    {
        require_once APP_PATH . 'library' . DIRECTORY_SEPARATOR . convert_path($lib) . '.php';
        $class = $lib . '_lib';
        $library = new $class();
        $this->{$lib} = $library;
    }
    function add_region($html){
        $this->region[] = $html;
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
        $this->load->view('errors' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $file, $params);
    }
    function add_cachedJavascript($js, $type = 'file', $pos="body:end", $data = array())
    {        
        try {
            if($type == 'file'){
                ob_start();
                if (!empty($data))
                    extract($data);
                    
                
                include_once ASSETS_PATH . 'js' . DIRECTORY_SEPARATOR . convert_path($js) . '.js';
            }

            $this->params['extra_js'][] = array(
                'script' => $type == 'file' ? ob_get_contents() : $js,
                'type' => 'inline',
                'pos' => 'body:end'
            );
            if($type == 'file')
                ob_end_clean();
            
        } catch (\Throwable $th) {
           print_r($th);
        }
    }
    function add_cachedStylesheet($css, $type = 'file', $pos = 'head', $data = array())
    {
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $this->params['var'][$k] = $v;
            }
        }
        if($type == 'file'){
            ob_start();
            if (!empty($data))
                extract($data);
            try {
                include_once ASSETS_PATH . 'css' . DIRECTORY_SEPARATOR . convert_path($css) . '.css';   
            } catch (\Throwable $th) {
                print_r($th);
            }
        }

        $this->params['extra_css'][] = array(
            'style' => $type == 'file' ? ob_get_contents() : $css,
            'type' => 'inline',
            'pos' => $pos
        );
        if($type == 'file')
            ob_end_clean(); 
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
        if(empty($this->views)){
            $this->view('header'. DIRECTORY_SEPARATOR .'main', $this->params);
        }
        foreach($this->region as $view){
            echo $view;
        }
        if(empty($this->views)){
            $this->view('footer'. DIRECTORY_SEPARATOR .'main', $this->params);
        }
        $this->views = [];
        $this->params = [];

    }
    function add_params($key = null, $value = null, array $arr = array()){
        if(!empty($key))
            $this->params[$key] = $value;
        if(!empty($arr))
            $this->params += $arr;
    }
}
