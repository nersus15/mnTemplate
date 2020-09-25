<?php

use function PHPSTORM_META\type;

class qbuilder
{
    private $db;
    private $query = "";
    private $countWhere = 0;
    private $countselect = 0;
    private $countjoin = 0;
    private $qeueu = array();
    private $new = true;
    private $functions = array("select", "from", "join", "where", "orwhere", "group_by", 'order_by', "subquery");
    private $bind_scirpt = array();
    private $hasil = null;
    public function __construct()
    {
        $this->db = new database;
    }

    function subquery($q1, $q2, $talias)
    {

        if ($this->new) {
            $this->qeueu['subquery'][] = array(
                'temp' => array(
                    'q1' => $q1,
                    'q2' => $q2,
                    'talias' => $talias
                )
            );
        } else {
            $this->query = $q1 . '(' . $q2 . ') ' . $talias;
        }
    }
    function group_by($kolom)
    {
        if ($this->new) {
            $this->qeueu['group_by'][] = array(
                'temp' => array(
                    'kolom' => $kolom,
                )
            );
        } else {
            $this->query .= ' GROUP BY ' . $kolom;
        }
    }

    /**
     * @param $tipe enum['ASC'|'DESC']
     */
    function order_by($kolom, $tipe = 'ASC')
    {
        if ($this->new) {
            $this->qeueu['order_by'][] = array(
                'temp' => array(
                    'kolom' => $kolom,
                    'tipe' => $tipe
                )
            );
        } else {
            $this->query .= ' ORDER BY ' . $kolom . ' ' . $tipe;
        }
    }

    function get_query()
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
            $query = $this->query;
            $this->reset();

            return $query;
        }
    }
    function join($tabel, $on, $tipe = "INNER")
    {

        if ($this->new) {
            $this->qeueu['join'][] = array(
                'temp' => array(
                    'tabel' => $tabel,
                    'on' => $on,
                    'tipe' => $tipe,
                )
            );
        } else {
            // if($this->countjoin >0)
            $this->query .= ' ' . $tipe . " JOIN " . $tabel . " ON " . $on;
        }
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
    function insert($input, $table)
    {
        $query = 'INSERT INTO ' . $table . '(';
        $jml = count($input);
        $bts = $jml - 1;
        $i = 0;
        foreach ($input as $k => $v) {
            if ($i != $bts)
                $query .= '`' . $k . '`, ';
            elseif ($i == $bts)
                $query .= '`' . $k . '`) VALUES (';

            $i++;
        }

        $i = 0;
        foreach ($input as $k => $v) {
            if ($i != $bts)
                $query .= '"' . $v . '", ';
            elseif ($i == $bts)
                $query .= '"' . $v . '")';

            $i++;
        }

        // var_dump($query);die;
        $this->db->query($query);
        $this->db->execute();
    }

    function insert_batch($inputs, $table)
    {
        $query = 'INSERT INTO ' . $table . '(';
        $juml_batch = count($inputs);
        $bts_batch = $juml_batch - 1;
        $jml = count($inputs[0]);
        $bts = $jml - 1;
        $j = 0;
        $i = 0;
        foreach ($inputs[0] as $k => $v) {
            if ($i != $bts)
                $query .= '`' . $k . '`, ';
            elseif ($i == $bts)
                $query .= '`' . $k . '`) VALUES (';

            $i++;
        }

        foreach ($inputs as $input) {
            $i = 0;
            foreach ($input as $k => $v) {
                if ($i != $bts)
                    $query .= '"' . $v . '", ';
                elseif ($i == $bts)
                    $query .= '"' . $v . '")';

                $i++;
            }

            $query .= $j != $bts_batch ? ', (' : null;
            $j++;
        }
        $this->db->query($query);
        $this->db->execute();
        // var_dump($query);
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
            $key_binding = 'VAR' . random(1) . random(1, 'int');
            if (is_string($nilai))
                $nilai = "$nilai";
            if (stristr($this->query, "where"))
                $this->query .= " and " . $kolom . " " . $operator . " :" . $key_binding;
            else
                $this->query .= " where " . $kolom . " " . $operator . " :" . $key_binding;

            $this->bind_scirpt[] = array(
                "key" => $key_binding,
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
            $this->reset();
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
            $this->reset();
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
            $this->reset();
            return $this->db->result_object();
        }
    }
    function call_function($f, $t, $index)
    {
        if ($f == "select")
            $this->select($t);

        if ($f == 'from')
            $this->from($t);

        if ($f == 'join')
            $this->join($t['tabel'], $t['on'], $t['tipe']);

        if ($f == "where")
            $this->where($t['kolom'], $t['nilai'], $t['operator']);

        if ($f == "orwhere")
            $this->or_where($t['kolom'], $t['nilai'], $t['operator']);

        if ($f == "group_by")
            $this->group_by($t['kolom']);

        if ($f == "order_by")
            $this->order_by($t['kolom'], $t['tipe']);

        if ($f == 'subquery')
            $this->subquery($t['q1'], $t['q2'], $t['talias']);

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
        $this->reset();
        return $this->hasil;
    }
    function reset()
    {
        $this->query = "";
        $this->countWhere = 0;
        $this->countselect = 0;
        $this->qeueu = array();
        $this->new = true;
        $this->bind_scirpt = array();
        $this->hasil = null;
    }
}
