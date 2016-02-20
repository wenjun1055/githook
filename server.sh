#!/bin/bash
PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin:~/bin
export PATH

echo -e "\033[35m ============================================================= \033[0m";
echo -e "\033[35m ********************** Githook ****************************** \033[0m";
echo -e "\033[35m Author: WenJun \033[0m";
echo -e "\033[35m Email: wenjun1055@gmail.com \033[0m";
echo '';

function ProxyManagement()
{
    if [ "$1" != '' ]; then
            selected=$1;
    else
        echo -e "\033[35m [Proxy] Githook Management please select: (1~6) \033[0m";
        select selected in 'start' 'stop' 'restart' 'reload' 'kill9' 'exit'; do break; done;
        echo '';
    fi;

    [ "$selected" == 'exit' ] && exit;

    homework=`pwd`;
    cd $homework;

    if [ "$selected" == 'start' ]; then
        /usr/bin/php server.php;
        ps x | grep 'githook' | grep -v 'grep' >/dev/null && echo -e "\033[42;34m [OK] Githook Start \033[0m";

    elif [ "$selected" == 'stop' ]; then
        master_pid=`cat ./tmp/swoole.pid`;
        kill -15 $master_pid && echo -e "\033[42;34m [OK] Worker Stop \033[0m";
        sleep 1;
        echo '';
        kill -9 $master_pid && echo -e "\033[42;34m [OK] Master Stop \033[0m";
        rm -rf ./tmp/swoole.pid;

    elif [ "$selected" == 'reload' ]; then
        master_pid=`cat ./tmp/swoole.pid`;
         kill -USR1 $master_pid &&  echo -e "\033[42;34m [OK] Githook Reload \033[0m";

    elif [ "$selected" == 'restart' ]; then
        master_pid=`cat ./tmp/swoole.pid`;
        kill -15 $master_pid && echo -e "\033[42;34m [OK] Worker Stop \033[0m";
        sleep 1;
        echo '';
        kill -9 $master_pid && echo -e "\033[42;34m [OK] Master Stop \033[0m";

        /usr/bin/php server.php;
        echo '';
        ps x | grep 'githook' | grep -v 'grep' >/dev/null && echo -e "\033[42;34m [OK] Githook Start \033[0m";

    elif [ "$selected" == 'kill9' ]; then
        ps -eaf |grep "githook" | grep -v "grep"| awk '{print $2}' | xargs kill -9;
        echo -e "\033[42;34m [OK] Kill All Process \033[0m";

    else
            NginxManagement;
            return;
    fi;
}

ProxyManagement $1;
echo '';