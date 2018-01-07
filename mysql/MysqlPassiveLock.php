<?php
require './MysqlCommon.class.php';
class MysqlPassiveLock extends MysqlCommon
{
    public function run()
    {
        $this->mysqli->begin_transaction();
        $result = $this->mysqli->query("SELECT num FROM goods WHERE id=1 LIMIT 1 FOR UPDATE");
        $row = $result->fetch_assoc();
        $num = intval($row['num']);
        if($num > 0){
            usleep(100);
            $this->mysqli->query("UPDATE goods SET num=num-1");
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
            $this->mysqli->commit();
            echo "fail3:".$num;
        }
    }
}
$solution = new MysqlPassiveLock();
if(isset($_GET['cmd']) && $_GET['cmd']=='run'){
    $solution->run();
}else{
    $solution->init();
}