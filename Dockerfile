FROM 097359246029.dkr.ecr.ap-southeast-2.amazonaws.com/bullseye-php74-nginx:latest as developer_php
RUN apt-get update \
    && apt-get install -y openssh-client git postgresql libpq-dev libgmp-dev libzip-dev python3-pip g++ gcc libxml2-dev libpng-dev apache2 openrc npm fonts-noto r-base wget sudo  \
    && apt-get install -y $PHPIZE_DEPS

RUN pecl install xdebug-3.1.2 \
    && pecl install redis \
    && docker-php-ext-enable xdebug redis \
    && pip3 install --upgrade pip \
    && pip3 install --upgrade awscli \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/* \
    && docker-php-ext-install pdo pdo_pgsql pgsql gmp zip intl gd

COPY 000-default.conf /etc/apache2/sites-enabled/
# Set ownership to web daemon
RUN mkdir -p /run/apache2
RUN mkdir -p /var/www/.npm
RUN chown -R www-data:www-data /var/lib/nginx
RUN chown -R www-data:www-data /var/www/.npm

# Start php-fpm and Nginx when the image is started
CMD ["./startup_php.sh"]

