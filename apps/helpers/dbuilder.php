<?php

use function PHPSTORM_META\type;

class dbuilder
{
    private $db;
    private $query = "";
    private $countWhere = 0;
    private $countselect = 0;
    private $qeueu = array();
    private $new = true;
    private $functions = array("select", "from", "where", "orwhere");
    private $bind_scirpt = array();
    private $hasil = null;
    public function __construct()
    {
        $this->db = new database;
    }

    function select($selection)
    {
        if ($this->new) {
            $this->qeueu['select'][] = array(
                'temp' => $selection
            );
        } else {
            if ($this->countselect > 0)
                $this->query .=  ", " . $selection;
            else
                $this->query .=  " SELECT " . $selection;

            $this->countselect++;
        }
    }
    function from($table)
    {
        if ($this->new) {
            $this->qeueu['from'][] = array(
                'temp' => $table
            );
        } else {
            $this->query .= " FROM " . $table;
        }
    }
    function where($kolom, $nilai, $operator = "=")
    {
        if ($this->new) {
            $this->qeueu['where'][] = array(
                'temp' => array(
                    'kolom' => $kolom,
                    'nilai' => $nilai,
                    'operator' => $operator
                )
            );
        } else {
            if (is_string($nilai))
                $nilai = "$nilai";
            if (stristr($this->query, "where"))
                $this->query .= " and " . $kolom . " " . $operator . " :" . $kolom . $this->countWhere;
            else
                $this->query .= " where " . $kolom . " " . $operator . " :" . $kolom . $this->countWhere;

            $this->bind_scirpt[] = array(
                "key" => $kolom . $this->countWhere,
                "value" => $nilai,
            );
            $this->countWhere++;
        }
    }
    function or_where($kolom, $nilai, $operator = "=")
    {
        if ($this->new) {
            $this->qeueu['orwhere'][] = array(
                'temp' => array(
                    'kolom' => $kolom,
                    'nilai' => $nilai,
                    'operator' => $operator
                )
            );
        } else {
            $this->query .= " OR " . $kolom . " " . $operator . " :" . $kolom . $this->countWhere;
            $this->bind_scirpt[] = array(
                "key" => $kolom . $this->countWhere,
                "value" => $nilai,
            );
            $this->countWhere++;
        }
    }
    function row()
    {
        $this->new = false;
        if (count($this->qeueu) > 0)
            $this->execute();

        if (count($this->qeueu) == 0) {
            $this->query .= "";
            $this->db->query($this->query);
            foreach ($this->bind_scirpt as $bind) {
                $this->db->bind($bind['key'], $bind['value']);
            }
            return $this->db->single();
        }
    }
    function results()
    {
        $this->new = false;
        if (count($this->qeueu) > 0)
            $this->execute();

        if (count($this->qeueu) == 0) {
            $this->query .= "";
            $this->db->query($this->query);
            foreach ($this->bind_scirpt as $bind) {
                $this->db->bind($bind['key'], $bind['value']);
            }
            return $this->db->resultSet();
        }
    }
    function result_object()
    {
        $this->new = false;
        if (count($this->qeueu) > 0)
            $this->execute();

        if (count($this->qeueu) == 0) {
            $this->query .= "";
            $this->db->query($this->query);
            foreach ($this->bind_scirpt as $bind) {
                $this->db->bind($bind['key'], $bind['value']);
            }
            return $this->db->result_object();
        }
    }
    function call_function($f, $t, $index)
    {
        if ($f == "select")
            $this->select($t);

        if ($f == 'from')
            $this->from($t);

        if ($f == "where")
            $this->where($t['kolom'], $t['nilai'], $t['operator']);

        if ($f == "orwhere")
            $this->or_where($t['kolom'], $t['nilai'], $t['operator']);

        unset($this->qeueu[$f][$index]);
    }
    function execute()
    {
        foreach ($this->functions as $f) {
            foreach ($this->qeueu as $k => $v) {
                if ($k == $f) {
                    foreach ($v as $key => $value)
                        $this->call_function($f, $value['temp'], $key);
                }
                if (empty($this->qeueu[$f]))
                    unset($this->qeueu[$f]);
            }
        }

        if (count($this->qeueu) > 0)
            $this->execute();
    }
    function get()
    {
        return $this->hasil;
    }
}
