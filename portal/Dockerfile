FROM php:8.5-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev libonig-dev libzip-dev unzip git \
    && docker-php-ext-install pdo_mysql mbstring intl zip bcmath opcache \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts --no-autoloader
COPY . .
RUN composer dump-autoload --no-dev --classmap-authoritative \
    && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && sed -ri 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && chmod +x docker/entrypoint.sh
EXPOSE 8080
ENTRYPOINT ["/var/www/html/docker/entrypoint.sh"]
