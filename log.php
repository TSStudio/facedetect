<?php
class logger{
    private $db;
    function __construct($dbhost, $dbuser, $dbpawd, $dbname){
        $this->db=new mysqli($dbhost, $dbuser, $dbpawd, $dbname);
        $this->log("info","A Logger Connected");
    }
    /**
     * @param $level Logging level
     * @param $info Logging Info
     * @return bool true:success,false:fail
     */
    public function log($level,$info){
        $time=time();
        if($this->db->query('INSERT INTO `logs` (time,level,info) values ('.$time.',"'.$level.'","'.$info.'")')){
            return true;
        }
        return false;
    }
    public function destory(){
        $this->db->close();
    }
}
/*使用方法
include "log.php";
$logger=new logger($dbhost, $dbuser, $dbpawd, $dbname);

$logger->log("info","");
$logger->destory();
*/