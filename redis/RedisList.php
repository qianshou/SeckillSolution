<?php
require './RedisCommon.class.php';
class RedisList extends RedisCommon
{
    public function init(){
        $this->redis->del('goods');
        for($i=1;$i<=10;$i++){
            $this->redis->lPush('goods',$i);
        }
        $this->redis->del('result');
        echo 'init done';
    }
    public function run(){
        $goods_id = $this->redis->rPop('goods');
        usleep(100);
        if($goods_id == false) {
            echo "fail1";
        }else{
            $res = $this->redis->lPush('result',$goods_id);
            if($res == false){
                echo "writelog:".$goods_id;
            }else{
                echo "success".$goods_id;
            }
        }
    }
}
$solution = new RedisList();
if(isset($_GET['cmd']) && $_GET['cmd']=='run'){
    $solution->run();
}else{
    $solution->init();
}