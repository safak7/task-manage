FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip

RUN pecl channel-update pecl.php.net

RUN apt-get update || apt-get update && apt-get install -y autoconf pkg-config libssl-dev libyaml-dev libmcrypt-dev libxml2-dev --fix-missing
RUN pecl install xdebug mongodb-1.5.3 yaml mcrypt-1.0.1
RUN docker-php-ext-install bcmath
RUN docker-php-ext-enable xdebug
RUN docker-php-ext-enable yaml
RUN docker-php-ext-enable mcrypt
RUN docker-php-ext-install bcmath ftp mbstring pdo pdo_mysql soap
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-configure zip --with-libzip \
  && docker-php-ext-install zip
RUN docker-php-ext-install mysqli

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install sockets

RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini
#RUN echo "extension=yaml.so" >> /usr/local/etc/php/conf.d/yaml.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Moscow /etc/localtime
RUN "date"

# Type docker-php-ext-install to see available extensions
#RUN docker-php-ext-install pdo pdo_mysql

ADD xdebug.ini /tmp/docker-xdebug.ini

RUN cat /tmp/docker-xdebug.ini >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN rm /tmp/docker-xdebug.ini

ADD entrypoint.sh /var/local/entrypoint.sh

RUN chmod +x /var/local/entrypoint.sh
RUN mkdir -p /var/log/php
RUN chown -R www-data: /var/log/php

RUN chmod 777 -R /tmp

WORKDIR /www
