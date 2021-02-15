<?php
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