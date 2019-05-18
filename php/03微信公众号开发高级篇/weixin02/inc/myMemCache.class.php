<?php
/**
 * Created by PhpStorm.
 * User: chenhuazhan
 * Date: 2019/5/18
 * Time: 10:19
 * Desc: memcache缓存
 */

class myMemCache
{
    public $link;
    public function __construct($host,$port)
    {
        $this->connect($host,$port);
    }

    private function connect($host,$port){
        $this->link = new Memcache; //创建Memcache对象
        $this->link->connect($host,$port); //连接Memcache服务器
    }
    public function setMemcache($key,$value,$time){
        $this->link->set($key,  $value,  0,  $time);
    }
    public function getMemcache($key){
        return $this->link->get($key);
    }
}