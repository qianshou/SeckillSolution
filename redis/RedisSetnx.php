<?php
require './RedisCommon.class.php';
class RedisSetnx extends RedisCommon
{
    public function run(){
        do {
            $res = $this->redis->setnx("numKey",1);
            $this->timeout -= 100;
            usleep(100);
        }while($res == 0 && $this->timeout>0);
        if($res == 0){
            echo 'fail1';
        }else{
            $num = $this->redis->get('num');
            if($num > 0) {
                $this->redis->decr('num');
                usleep(100);
                $res = $this->redis->lPush('result',$num);
                if($res == false){
                    echo "fail2";
                }else{
                    echo "success:".$num;
                }
            }else{
                echo "fail3";
            }
            $this->redis->del("numKey");
        }
    }
}
$solution = new RedisSetnx();
if(isset($_GET['cmd']) && $_GET['cmd']=='run'){
    $solution->run();
}else{
    $solution->init();
}