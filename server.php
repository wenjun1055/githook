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
$httpServerObj->on('request', function (swoole_http_request $request, swoole_http_response $response) use ($httpServerObj, $aWhiteIpList) {
    $sIp = $request->server['remote_addr'];
    if (!empty($aWhiteIpList) && !in_array($sIp, $aWhiteIpList)) {
        $response->end('error');
        return true;
    }

    $sRequestUri = $request->server['request_uri'];
    $sRequestUri = trim($sRequestUri, '/');
    $httpServerObj->task($sRequestUri);
    $response->end('ok');
});
$httpServerObj->on('Task', function(swoole_server $serverObj, $taskId, $fromId, $data) use ($aRepoConfig) {
    if (!isset($aRepoConfig[$data])) {
        return true;
    }
    exec($aRepoConfig[$data]);
    return true;
});
$httpServerObj->on('Finish', function(swoole_server $serverObj, $taskId, $data) {
    return true;
});
$httpServerObj->start();

