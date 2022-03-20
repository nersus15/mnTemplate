<?php
$jwt = new Token;
// SECURE FORM
function buat_form($template, $id = null, $action = null, $formdata = array(), $tipe = 'file'){ // $tipe = ['file', 'html'] html berarti html langsung
    global $jwt;

    /** @var controller */
    $controller = core();
    $key = "_token_";
    $token_akses = $jwt->minta_token($id);

    if($tipe == 'file'){
        if (!empty($formdata))
            extract($formdata);

        ob_start();
        require_once APP_PATH . 'views' . DIRECTORY_SEPARATOR . convert_path($template) . '.php';
        $view = ob_get_clean();


        $html = '<main><div class="container-fluid" style=""><div class="col-12">' . $view . '</div></div></main>';
    }else
        $html = $template;
    $html = str_replace("</form>", '<input type="hidden" name="'.$key.'" value="'. $token_akses .'"> </form>', $html);

    return $html;


}

function fieldmapping($input, $conf, $defaultValue = array(), $petaNilai = array())
{
    $config = config_item('forms', array('field_mapping', $conf));
    $field = array();
    $reverseConfig = array_flip($config);
    $adaDefault = count($defaultValue) > 0;
    $adaPeta = count($petaNilai) > 0;
    if (empty($config))
        response(['message' => 'Config form ' . $config . ' Kosong'], 404);

    foreach ($config as $k => $v) {
        if(SECURE_FORM){
            $k = sandi($k);
        }

        if (isset($input[$k]))
            $field[$v] = $input[$k];
        elseif(!isset($input[$k]) && $adaDefault && in_array($k, array_keys($defaultValue)))
            $field[$v] = $defaultValue[sandi($k)];
    }
    if($adaPeta){
        foreach($petaNilai as $f => $peta){
            foreach($peta as $k => $v){
                if(isset($field[$config[$f]]) && $field[$config[$f]] == $k)
                    $field[$config[$f]] = $v;
            }
        }
    }
    return $field;
}