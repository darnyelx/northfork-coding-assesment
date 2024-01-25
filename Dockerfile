# Use the official PHP image
FROM php:8.1-fpm

RUN apt-get update \
    && apt-get install -y \
        curl \
        git \
        unzip \
        libicu-dev \
        libzip-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo_mysql zip \
    && pecl install apcu \
    && docker-php-ext-enable apcu

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install --no-scripts --no-autoloader

COPY . .

RUN composer dump-autoload --optimize

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 9000



# Use the entrypoint script
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

# Command to run PHP-FPM
CMD ["php-fpm"]

