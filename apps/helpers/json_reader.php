<?php
class jsonReader
{
    protected $file;

    function init($file)
    {
        if (!file_exists($file))
            return array("message" => "Error! File tidak ditemukan di " . $file);

        $this->file = $file;
    }
    function read()
    {
        $data = file_get_contents($this->file);
        // foreach($data as $k => $v){

        // }
        return empty($data) ? null : json_decode($data, true);
    }
    function add($key, $value)
    {
        $data = $this->read();
        $data[$key] = $value;
        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT));
    }
    function clear()
    {
    }
}
