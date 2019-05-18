<?php
/**
 * Created by PhpStorm.
 * User: 18476
 * Date: 2019/5/14
 * Time: 10:44
 */
$host = '127.0.0.1';            //MySQL服务器地址
$username = 'root';                //用户名
$passwd = 'chz';                //密码
$dbname = 'wechat';                //数据库名称

$link = @new mysqli($host, $username, $passwd, $dbname);
if ($link->connect_error) {
    die('Connect Error (' . $llink->connect_errno . ') ' . $llink->connect_error);
}
$link->select_db($dbname) or die('数据库选择失败！');
$sql = "set names utf8mb4";
$link->query($sql);