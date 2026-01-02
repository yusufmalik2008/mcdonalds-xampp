FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libzip-dev zip \
    && docker-php-ext-install pdo_mysql zip \
    && a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY .htaccess /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80