FROM php:7.3-apache

COPY . /var/www/html/

RUN a2enmod rewrite

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get update && apt-get install -y --fix-missing \
    vim nano curl debconf apt-transport-https apt-utils \
    build-essential locales acl mailutils \
    zip unzip zlib1g-dev libzip-dev \
    gnupg gnupg1 gnupg2 \
    openssl

RUN docker-php-ext-install pdo pdo_mysql mysqli mbstring zip

RUN pecl install xdebug-2.7.2

RUN docker-php-ext-enable xdebug