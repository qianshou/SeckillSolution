<?php
class MysqlCommon
{
    protected $mysqli;
    public function __construct()
    {
        $this->mysqli = new mysqli("127.0.0.1", "root", "", 'test');
        if ($this->mysqli->connect_errno) {
            exit('connect error:' . $this->mysqli->connect_error);
        }
        $this->mysqli->set_charset('utf8');
    }
    public function __destruct()
    {
        $this->mysqli->close();
    }
    public function init()
    {
        $this->mysqli->query("TRUNCATE TABLE goods");
        $this->mysqli->query("TRUNCATE TABLE log");
        $this->mysqli->query("INSERT INTO goods(id,num,version) VALUES(1,10,1)");
        echo "init done";
    }
}