<?php
/**
 * Created by PhpStorm.
 * User: chenhuazhan
 * Date: 2019/5/18
 * Time: 11:13
 * Desc: mysql操作类
 */
class mysql
{
    private $host;
    private $port;
    private $user;
    private $pass;
    private $dbname;
    private $charset;

    private $link;
    public $affected_rows;
    public $num_rows;

    public function __construct(array $info =array()){
        $this->host = $info['host'];
        $this->port = $info['port'];
        $this->user = $info['user'];
        $this->pass = $info['pass'];
        $this->dbname = $info['dbname'];
        $this->charset = $info['charset'];
        $this->sqlConn();
        $this->sqlCharset();
    }
    //连接数据库
    private function sqlConn(){
        $this->link = @new mysqli($this->host,$this->user,$this->pass,$this->dbname,$this->port);
        if($this->link->connect_error){
            die('Connect Error ('.$this->link->connect_errno.')'.$this->link->connect_error);
        }
    }
    //设置字符集
    private function sqlCharset(){
        $sql = "set names {$this->charset}";
        $res = $this->link->query($sql);

        if(!$res){
            die('Charset Error('.$this->link->errno.')'.$this->link->error);
        }
    }
    //数据库写操作
    public function sqlExec($sql){
        $res = $this->link->query($sql);
        if(!$res){
            die('Sql Error('.$this->link->errno.')'.$this->link->error);
        }
        $this->affected_rows = $this->link->affected_rows;
        return $res;
    }
    //获取数据表中的最后一个id
    public function getSqlLastId(){
        return $this->link->insert_id;
    }
    //数据库查询操作
    public function sqlQuery($sql,$all = false){
        $res = $this->link->query($sql);
        if(!$res){
            die('Sql Error('.$this->link->errno.')'.$this->link->error);
        }
        if($all){
            return $res->fetch_all(MYSQLI_ASSOC);
        }else{
            return $res->fetch_assoc();
        }
    }

}