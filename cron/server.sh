#!/bin/bash

while true
do
es=$(ps aux | grep SocketServer.php | grep -v grep)
if [ -z "$es" ]
then
php /var/www/html/ams_system/cron/SocketServer.php &
fi
done
