<?php
class user extends controller
{
    function login()
    {
        $pos = $_POST;
    }
    function datauser()
    {
        $data = array();
        echo json_encode($data);
    }
}
