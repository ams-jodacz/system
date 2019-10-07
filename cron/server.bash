#!/bin/bash

while true
do
es=$(ps aux | grep SocketServer.php | grep -v grep)
if [ -z "$es" ]
then
php SocketServer.php &
fi
done
