FROM php:8.1-fpm

RUN docker-php-ext-install sockets

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install pcntl

WORKDIR /app

