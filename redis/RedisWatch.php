<?php
require './RedisCommon.class.php';
class RedisWatch extends RedisCommon
{
    public function run(){
        $num = $this->redis->get('num');
        if($num > 0) {
            $this->redis->watch('num');
            usleep(100);
            $res = $this->redis->multi()->decr('num')->lPush('result',$num)->exec();
            if($res == false){
                echo "fail1";
            }else{
                echo "success:".$num;
            }
        }else{
            echo "fail2";
        }
    }
}
$solution = new RedisWatch();
if(isset($_GET['cmd']) && $_GET['cmd']=='run'){
    $solution->run();
}else{
    $solution->init();
}