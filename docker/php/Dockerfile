FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install pdo pdo_mysql gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

RUN composer install --no-dev --prefer-dist --no-interaction

RUN if [ ! -f .env ]; then cp .env.example .env; fi

RUN if [ -f artisan ] && ! grep -q "APP_KEY=" .env; then php artisan key:generate; fi

RUN if [ -f artisan ]; then php artisan config:clear; fi

EXPOSE 8080 8081 8000 8082

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]


