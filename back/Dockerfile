FROM php:8.1-fpm
RUN apt-get update && apt-get install -y libpq-dev curl libcurl4-openssl-dev libxml2-dev zlib1g-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev openssl zip unzip git libonig-dev libtidy-dev libzip-dev nano libjpeg-dev libfreetype6-dev pkg-config libssl-dev libmcrypt-dev libdlib-dev libblas-dev libatlas-base-dev liblapack-dev libjpeg62-turbo-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install curl dom gd mbstring pdo pdo_mysql pdo_pgsql pgsql simplexml soap tidy zip sockets intl mysqli bcmath
RUN pecl install mcrypt && docker-php-ext-enable mcrypt
RUN pecl install pcov && docker-php-ext-enable pcov
RUN mkdir /app
WORKDIR /app
COPY .docker/php.ini /usr/local/etc/php/php.ini
COPY .docker/openssl.cnf /etc/ssl/openssl.cnf
ADD http://www.cacert.org/certs/root.crt /usr/local/share/ca-certificates/cacert.crt
RUN update-ca-certificates
RUN ln -s /usr/local/bin/php /usr/bin/php
RUN chmod +x /usr/bin/php

COPY . .
ENV COMPOSER_ALLOW_SUPERUSER=1

CMD bash -c "sleep 5 && composer install && php migration && php -S 0.0.0.0:8000 -t public"