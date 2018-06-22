FROM php:7.2-fpm

RUN apt-get update -qq \
    && apt-get install -y -qq --no-install-recommends \
        libpq-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        calendar \
        gd \
    && pecl install redis-3.1.3 \
    && docker-php-ext-enable redis

COPY ./docker/php-fpm/overrides.ini /usr/local/etc/php/50-overrides.ini
COPY ./docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/html

COPY ./ /var/www/html/

#RUN php artisan config:cache \
#	&& php artisan view:cache \
#	&& php artisan route:cache
