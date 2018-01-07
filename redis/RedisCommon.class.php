<?php
class RedisCommon
{
    protected $redis;
    public function __construct(){
        $this->redis = new Redis();
        if($this->redis->connect('192.168.20.131',6379,1) == false) exit('redis connection timeout');
    }
    public function __destruct()
    {
        $this->redis->close();
    }
    public function init(){
        $this->redis->set('num',10);
        $this->redis->del('result');
        echo 'init done';
    }
}