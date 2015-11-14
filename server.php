<?php
/**
 * @Author: WenJun
 * @Date:   15/8/13 16:23
 * @Email:  wenjun01@baidu.com
 * @File:   http_server.php
 * @Desc:   ...
 */
ini_set('display_errors', 1);
ini_set('memory_limit','512M');
error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');

define('DS', DIRECTORY_SEPARATOR);
define('WORKSPACE', __DIR__);

require_once WORKSPACE . DS . 'config.php';

//server init
$httpServerObj = new swoole_http_server(SERVER_LISTEN_IP, SERVER_LISTEN_PORT);
$httpServerObj->set($aServerSetting);
$httpServerObj->on('request', function(swoole_http_request $request, swoole_http_response $response) {
    var_dump($request);
});
$httpServerObj->on('Task', '\Action\Tasker::task');
$httpServerObj->start();

