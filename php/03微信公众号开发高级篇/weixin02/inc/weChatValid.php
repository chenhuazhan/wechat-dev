<?php
/**
 * Created by PhpStorm.
 * User: 18476
 * Date: 2019/5/18
 * Time: 14:21
 * Desc: 微信接口配置信息认证
 */
valid();

//接口验证
function valid()
{
    $echoStr = $_GET["echostr"];

    //valid signature , option
    if (checkSignature()) {
        echo $echoStr;
    }
}

// 检验签名
function checkSignature()
{
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];
    $token = TOKEN;
    $tmpArr = array($token, $timestamp, $nonce);
    sort($tmpArr, SORT_STRING);
    $tmpStr = implode($tmpArr);
    $tmpStr = sha1($tmpStr);

    if ($tmpStr == $signature) {
        return true;
    } else {
        return false;
    }
}