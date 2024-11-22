# Use the official PHP image as a base image to construct our own image from
FROM php:8.2.12-apache

# Install and enable mysql modules for PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    docker-php-ext-enable mysqli pdo pdo_mysql

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    zip \
     && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install zip

RUN docker-php-ext-enable intl mbstring zip

# Set an environment variable which contains the apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public


# Update the apache configuration using the `APACHE_DOCUMENT_ROOT` environment variable
ADD apache_vhost.conf /etc/apache2/sites-available/000-default.conf

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
RUN HASH=`curl -sS https://composer.github.io/installer.sig`
RUN php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN apt-get update
RUN apt-get -y install git

