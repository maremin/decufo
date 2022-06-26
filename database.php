<?php
class Database
{
    private $host;
    private $port;
    private $db;
    private $user_name;
    private $user_pwd;
    private $crs;
    private $connection;

    public function __construct()
    {
        $data = parse_ini_file('db.ini');
        $this->host = $data["host"];
        $this->port = $data["port"];
        $this->db = $data["db"];
        $this->user_name = $data["user_name"];
        $this->user_pwd = $data["user_pwd"];
        $this->crs = $data["crs"];
        $this->getDb();
    }

    private function getDb()
    {
        $this->connection = new PDO('mysql:host=' . $this->host . ':' . $this->port . ';charset=' . $this->crs . ';dbname=' . $this->db, $this->user_name, $this->user_pwd);
    }

    //выполнение запроса(+)
    public function doRequest($sql, $param = [])
    {
        $result = $this->connection->prepare($sql);
        $result->execute($param);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // получение ассоциативного массива всей таблицы(+)
    public function selectAll($sql, $param = [])
    {
        $query = $this->connection->prepare($sql);
        $query->execute($param);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // получение первого столбца запрашиваемой таблицы (+)
    public function selectFirstColumn($sql, $param = [])
    {
        $query = $this->selectAll($sql, $param);
        $columnIndex = array_key_first($query[0]);
        $result = array_column($query, $columnIndex);
        return $result;
    }

    // добавление записи(+)
    public function getInsert($sql, $param = [])
    {
        $query = $this->doRequest($sql, $param);
        return $this->connection->lastinsertid();
    }

    // получение только строки таблицы по запросу(+)
    public function selectArrayKey($sql, $param = [], $value)
    {
        $query = $this->connection->prepare($sql);
        $query->execute($param);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result[$value];
    }

    // получение значения первого столбца первой строки указанного запроса(+)
    public function selectFirstCell($sql, $param = [])
    {
        return $this->selectFirstColumn($sql, $param)[0];
    }

    // подсчёт общего количества строк в таблице(+)
    public function countRow($sql, $param = [])
    {
        $array = $this->selectAll($sql, $param);
        return count($array);
    }
}
