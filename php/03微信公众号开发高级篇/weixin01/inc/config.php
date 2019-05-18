<?php
/**
 * Created by PhpStorm.
 * User: chenhuazhan
 * Date: 2019/5/18
 * Time: 13:23
 * Desc: 项目配置文件
 */

$config = [
    'appid1' => 'wx2870147026ee4123',
    'appsecret1' => '49e4fb9fe74e6d5bf9fe94fe19731366',
    'appid2' => 'wx89b0cc0671397348',
    'appsecret2' => '4e5607d08392210c2638f8b194da4ce5',
    'token'=> 'weixin',
    'mysql' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'root',
        'pass' => 'chz',
        'dbname' => 'wechat',
        'charset' => 'utf8mb4',
    ],
    'music' => [
        [
            'title' => '爱情的故事',
            'singer' => '群星',
            'url' => '1.mp3'
        ], [
            'title' => '罗密欧与朱丽叶',
            'singer' => '群星',
            'url' => '2.mp3'
        ], [
            'title' => '幸福梦',
            'singer' => '张碧晨',
            'url' => '3.mp3'
        ], [
            'title' => 'Could You Stay With Me-Could You Stay With Me',
            'singer' => '张靓颖',
            'url' => '4.mp3'
        ]
    ],
    'button' => [
        [
            'type' => 'click',
            'name' => '开心一刻',
            'key' => 'JOKE',
        ],
        [
            'type' => 'view',
            'name' => '游戏中心',
            'url' => 'http://152.136.130.234/app/games/index.html'
        ],
        [
            'type' => 'click',
            'name' => '搜索周边',
            'key' => 'SEARCH'
        ]
    ]
];

return $config;