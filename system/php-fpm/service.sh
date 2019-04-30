#!/bin/sh
# `/sbin/setuser root` runs the given command as the user `root`.
# If you omit that part, the command will be run as root.
exec /usr/sbin/php-fpm7.2 --allow-to-run-as-root -c /etc/php/7.2/fpm/php.ini -g /run/php/php7.2-fpm.pid --nodaemonize > /dev/null 2>&1