#!/bin/sh
# `/sbin/setuser root` runs the given command as the user `root`.
# If you omit that part, the command will be run as root.
exec /usr/sbin/nginx -c /etc/nginx/nginx.conf > /dev/null 2>&1