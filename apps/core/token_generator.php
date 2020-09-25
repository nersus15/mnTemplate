<?php
class Token
{
    protected $token = array();
    protected $fs;

    function init()
    {
       
    }
    function generate($value)
    {
        $id = uniqid();
        $value = array('aktif' => true, 'value' => $value);
        // $this->fs->add($id, $value);
        var_dump($this->fs->read());

        return $id;
    }

    function validate($token)
    {
        if (!isset($this->token[$token]))
            return array("message" => "error! Token tidak valid", "status" => false);

        if (!$this->token[$token]['aktif'])
            return array("message" => "error! Token sudah digunakan", "status" => false);

        $this->token[$token]['aktif'] = false;
        return true;
    }
    function reset($token)
    {
        $temp = $this->token[$token]['value'];
        unset($this->token[$token]);
        return $this->generate($temp);
    }
}
