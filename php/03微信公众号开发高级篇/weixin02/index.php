<?php
/**
 * Created by PhpStorm.
 * User: chenhuazhan
 * Date: 2019/5/18
 * Time: 9:40
 * Desc: 微信入口文件
 */

header('Content-Type: text/html;charset=utf-8');

$serverRoot = __DIR__;
$config = include_once $serverRoot . '/inc/config.php';

define("TOKEN", $config['token']);

if (@$_GET["echostr"]) {
    // 微信接口配置信息认证
    include_once $serverRoot . '/inc/weChatValid.php';
    exit;
}

include_once $serverRoot . '/inc/weChat.class.php';
include_once $serverRoot . '/inc/weChatReply.class.php';
include_once $serverRoot . '/inc/myMemCache.class.php';
include_once $serverRoot . '/inc/mysql.class.php';
include_once $serverRoot . '/inc/curl.class.php';
$appid = $config['appid1'];
$appsecret = $config['appsecret1'];
$wechatObj = new weChat($appid, $appsecret);
if (@$_GET['menu']) {
    // 微信菜单创建/查询/删除
    switch ($_GET['menu']) {
        case 'create':
            $data = json_encode(['button' => $config['button']], JSON_UNESCAPED_UNICODE);

            $arr = $wechatObj->menuCreate($data);
            echo "<pre>";
            print_r($arr);
            break;

        case 'select':
            $arr = $wechatObj->menuSelect();
            echo "<pre>";
            print_r($arr);
            break;

        case 'del':
            $arr = $wechatObj->menuDel();
            echo "<pre>";
            print_r($arr);
            break;
        default:
            echo '没有该操作';
    }
    exit;
}

if (@$_GET['send']) {
    // 处理发送消息请求
    switch ($_GET['send']) {
        case 'text':
            $arr = $wechatObj->sendText($_GET['text']);
            var_dump($arr);
            break;

        case 'image':
            $arr = $wechatObj->sendImage($_GET['media_id']);
            echo "<pre>";
            print_r($arr);
            break;

        case 'tmp':
            $arr = [
                'num' => 5
            ];
            $arr = $wechatObj->sendTmp($_GET['openid'],$_GET['tmp_id'],$arr);
            echo "<pre>";
            print_r($arr);
            break;
        default:
            echo '没有该操作';
    }
    exit;
}

// 被动响应处理
$wechatObj->responseMsg();


