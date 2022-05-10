FROM php:7.4.21-apache
COPY src/ /var/www/html/src/
RUN apt-get update && \
    docker-php-ext-install pdo_mysql
