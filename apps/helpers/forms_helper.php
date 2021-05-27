<?php
$jwt = new Token;
// SECURE FORM
function buat_form($template, $id = null, $data = array(), $tipe = 'file'){ // $tipe = ['file', 'html'] html berarti html langsung
    global $jwt;

    /** @var controller */
    $controller = core();
    if (!empty($data))
        extract($data);

    if($tipe == 'file'){
        ob_start();
        require_once APP_PATH . 'views/' . $template . '.php';
        $view = ob_get_clean();
        // $key = password_hash("_token_", PASSWORD_DEFAULT);
        $key = "_token_";
        $token_akses = random(15);
        // TODO LOAD DATA AND STORE TO SESSION [$token_akses => $jwt->encode($data)]
        $data = array("waktu_akses" => waktu(), 'formid' => $id);

        set_userdata("_wrapped_data_", array($token_akses => $jwt->encode("_formtoken_", $data)));

        $html = '<main><div class="container-fluid" style=""><div class="col-12">' . $view . '</div></div></main>';
        $html = str_replace("</form>", '<input type="hidden" name="'.$key.'" value="'. $token_akses .'"> </form>', $html);
    }else
        $html = $template;

    return $html;


}

function fieldmapping($input, $conf, $defaultValue = array(), $petaNilai = array())
{
    $config = config_item('forms', array('field_mapping', $conf));
    $field = array();
    $adaDefault = count($defaultValue) > 0;
    $adaPeta = count($petaNilai) > 0;
    if (empty($config))
        response(['message' => 'Config form ' . $config . ' Kosong'], 404);

    foreach ($config as $k => $v) {
        if (isset($input[$k]))
            $field[$v] = $input[$k];
        elseif(!isset($input[$k]) && $adaDefault && in_array($k, array_keys($defaultValue)))
            $field[$v] = $defaultValue[$k];
    }
    if($adaPeta){
        foreach($petaNilai as $f => $peta){
            foreach($peta as $k => $v){
                if($field[$f] == $k)
                    $field[$f] = $v;
            }
        }
    }
    return $field;
}