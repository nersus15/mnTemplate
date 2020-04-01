<?php
class password extends controller
{


    function passwords($where = null, $limit = null)
    {
        $db = $this->helper('dbuilder');
        $db->select("*");
        $db->from('password');
        $data = json_encode($db->result_object());
        echo $data;
    }
}
