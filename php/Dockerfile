FROM php:8.3-fpm

RUN apt-get update && \
    apt-get install -y zip libzip-dev libpng-dev

RUN docker-php-ext-install mysqli pdo pdo_mysql gd zip