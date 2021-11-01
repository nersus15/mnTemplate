<?php
class database
{

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $name = DB_NAME;

    private $dbh;
    private $stmt;

    public function __construct()
    {
        //database source name
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->name;
        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
        } catch (PDOExceptioin $e) {
            die($e->getMessage());
        }
    }
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }
    //binding query
    public function bind($param, $value, $type = null)
    {

        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    //menjalankan query
    public function execute()
    {
        $this->stmt->execute();
        // var_dump($this->stmt);
        // die;
    }
    //mengambil semua hasil query
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //mengambil satu hasil query
    public function single()
    {
        $this->execute();
        return $this->stmt->Fetch(PDO::FETCH_ASSOC);
    }
    public function rowCount()
    {
        $this->execute();
        return $this->stmt->rowCount();
    }
    public function result_object()
    {
        $data = $this->resultSet();
        $object = [];
        foreach($data as $k => $v)
            $object[$k] = (object) $v;
        
        return $object;
    }
    public function single_object()
    {
        $this->execute();
        return $this->stmt->Fetch(PDO::FETCH_ORI_REL);
    }
}
