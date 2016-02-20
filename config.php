<?php
/**
 * @Author: WenJun
 * @Date  :   15/11/14 17:09
 * @Email :  wenjun1055@gmail.com
 * @File  :   config.php
 * @Desc  :   ...
 */

//服务监听的IP和端口
define('SERVER_LISTEN_IP', '0.0.0.0');
define('SERVER_LISTEN_PORT', 9876);
//rename进程名
define('MASTER_PROCESS_NAME', 'githook: master');
define('MANAGER_PROCESS_NAME', 'githook: manager');
define('WORKER_PROCESS_NAME', 'githook: worker %d');
define('TASKER_PROCESS_NAME', 'githook: tasker: %d');


//server setting
$aServerSetting = array(
    'dispatch_mode'       => 3,
    'reactor_num'         => 1,
    'worker_num'          => 1,
    'daemonize'           => 1,
    'task_worker_num'     => 4,
    'task_tmpdir'         => '/tmp',
    'task_ipc_mode'       => 3,
    'log_file'            => WORKSPACE . DS . 'logs/swoole.log',
);

//访问ip白名单
$aWhiteIpList = array(
//    '127.0.0.1',
);

//每个uri对应的脚本
$aRepoConfig = array(
    'test' => '/bin/sh ' . WORKSPACE . DS . 'scripts' . DS . 'test.sh >> ' . WORKSPACE . DS . 'logs/git.log',
);