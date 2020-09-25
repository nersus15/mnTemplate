<?php


function isLogin()
{
    return isset($_SESSION['login']);
}

function token_register_checker($token)
{
    if (empty($token))
        return['message' => 'Token kosong', 'type' => false];

    $db = new qbuilder();

    $db->select('*');
    $db->from('token_registrasi');
    $db->where('id', $token);
    $results = $db->results();
    if (empty($results))
        return['message' => 'Token registrasi yang anda masukkan tidak terdaftar', 'type' => false];
    if (count($results) > 1)
        return['message' => 'Token registrasi yang anda masukkan tidak valid', 'type' => false];

    $results = $results[0];
    if (strtotime($results['expired']) < time())
        return['message' => 'Token registrasi yang anda masukkan sudah expired', 'type' => false];
    
    return ['message' => null, 'type' => true];
}
