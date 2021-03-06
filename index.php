<?php

require 'vendor/autoload.php';

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Message;

$config = [
    'app_id' => 'wx9c30cd0e6976f516',
    'secret' => '01e4421a63218f167ad78e0102f26cd8',
    'token'   => 'cy.com',
    // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
    'response_type' => 'array',

    //...
];

$app = Factory::officialAccount($config);

$app->server->push(function ($message) {
    switch ($message['MsgType']) {
        case 'event':
            if ($message['Event'] == 'unsubscribe') {
                file_put_contents('/var/www/wx/message.text', '用户取消关注');
            }
            if ($message['Event'] == 'subscribe') {
                return 'welcome to my website!!!';
            }
            break;
        case 'text':
            return '收到文字消息';
            break;
        case 'image':
            return '收到图片消息';
            break;
        case 'voice':
            return '收到语音消息';
            break;
        case 'video':
            return '收到视频消息';
            break;
        case 'location':
            return '收到坐标消息';
            break;
        case 'link':
            return '收到链接消息';
            break;
        case 'file':
            return '收到文件消息';
        // ... 其它消息
        default:
            return '收到其它消息';
            break;
    }

    // ...
});

$response = $app->server->serve();

// 将响应输出
$response->send();exit; // Laravel 里请使用：return $response;