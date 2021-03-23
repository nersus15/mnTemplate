<?php
function is_login($role = null, $user = null)
{
    /** @var qbuilder $db */
    $db = new qbuilder();

    if (!JWT_AUTH)
        $userdata = sessiondata('login'); //sessiondata('login')
    else {
        $token = isset($_POST['_token']) ? $_POST['_token'] : null;
        list($isLogin, $data) = verfify_token($token);
    }
    if (!empty($userdata) && SYNC_DATAUSER) {
        $db->select('users.username, anggota.*');
        $db->where('username', $userdata['username']);
        $db->from('users');
        $db->join('anggota', 'users.anggota = anggota.id');
        $u = $db->results();

        if (count($u) > 1 || empty($u))
            return false;
        else
            set_userdata('login', $u[0]);

        $userdata = get_userdata('login');
    }

    if (empty($role) && empty($user)) {
        if (JWT_AUTH)
            return $isLogin;
        else
            return !empty($userdata);
    } elseif (!empty($userdata) && !empty($role) && empty($user)) {
        if (JWT_AUTH)
            return $data['role'] == $role;
        elseif (!JWT_AUTH && $role == 'bendahara')
            return $userdata['role'] == 'bendahara 1' || $userdata['role'] == 'bendahara 2';
        elseif (!JWT_AUTH && $role == 'admin')
            return $userdata['role'] == 'ketua yayasan' || $userdata['role'] == 'kepala sekolah';
        elseif (!JWT_AUTH && $role != 'bendahara')
            return $userdata['role'] == $role;
    } elseif (!empty($userdata) && empty($role) && !empty($user)) {
        if (JWT_AUTH)
            $data['username'] == $user;
        else
            return $userdata['username'] == $user;
    } elseif (!empty($userdata) && !empty($role) && !empty($user)) {
        if (JWT_AUTH)
            return $data['username'] == $user && $data['role'] == $role;
        else
            return $userdata['username'] == $user && $userdata['role'] == $role;
    }
}

function loginTryCount(){
    
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
