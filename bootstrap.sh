#!/bin/bash

mkdir -p /tmp/ices
chown www-data /tmp/ices
chown -R www-data:root /media

icecast -b -c /usr/local/etc/icecast.xml
sleep 2

php-fpm7.0
lighttpd -f /etc/lighttpd/lighttpd.conf

while true; do sleep 10; done

