# This script runs when the Docker container runs on a server
# It must run in SH, BASH, and ASH shells, so it uses odd syntax
set -e

sed -i "s,LoadModule mpm_prefork_module modules/mod_mpm_prefork.so,#LoadModule mpm_prefork_module modules/mod_mpm_prefork.so,g" /etc/apache2/apache2.conf


# start container threads
php-fpm &
apachectl -D FOREGROUND
