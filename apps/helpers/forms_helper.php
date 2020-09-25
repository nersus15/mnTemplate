<?php
function fieldmapping($input, $conf)
{
    $config = config_item('forms', array('field_mapping', $conf));
    $field = array();
    if (empty($config))
        response(['message' => 'Config form ' . $config . ' Kosong'], 404);

    foreach ($config as $k => $v) {
        if (isset($input[$k]))
            $field[$v] = $input[$k];
    }
    return $field;
}
