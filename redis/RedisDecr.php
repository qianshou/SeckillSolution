<?php
require './RedisCommon.class.php';
class RedisDecr extends RedisCommon {
    public function run(){
        $num = $this->redis->get('num');
        if($num > 0) {
            usleep(100);
            $retNum = $this->redis->decr('num');
            if($retNum >= 0){
                $res = $this->redis->lPush('result',$retNum);
                if($res == false){
                    echo "writeLog:".$retNum;
                }else{
                    echo "success:".$retNum;
                }
            }else{
                echo "fail1";
            }
        }else{
            echo "fail2";
        }
    }
}
$solution = new RedisDecr();
if(isset($_GET['cmd']) && $_GET['cmd']=='run'){
    $solution->run();
}else{
    $solution->init();
}