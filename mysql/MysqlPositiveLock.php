<?php
require './MysqlCommon.class.php';
class MysqlPositiveLock extends MysqlCommon
{
    public function run()
    {
        $result = $this->mysqli->query("SELECT num,version FROM goods WHERE id=1 LIMIT 1");
        $row = $result->fetch_assoc();
        $num = intval($row['num']);
        $version = intval($row['version']);
        if($num > 0){
            usleep(100);
            $this->mysqli->begin_transaction();
            $this->mysqli->query("UPDATE goods SET num=num-1,version=version+1 WHERE version={$version}");
            $affected_rows = $this->mysqli->affected_rows;
            if($affected_rows == 1){
                $this->mysqli->query("INSERT INTO log(good_id) VALUES({$num})");
                $affected_rows = $this->mysqli->affected_rows;
                if($affected_rows == 1){
                    $this->mysqli->commit();
                    echo "success:".$num;
                }else{
                    $this->mysqli->rollback();
                    echo "fail1:".$num;
                }
            }else{
                $this->mysqli->rollback();
                echo "fail2:".$num;
            }
        }else{
            echo "fail3:".$num;
        }
    }
}
$solution = new MysqlPositiveLock();
if(isset($_GET['cmd']) && $_GET['cmd']=='run'){
    $solution->run();
}else{
    $solution->init();
}