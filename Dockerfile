FROM php:8.3-cli

RUN apt-get update && apt-get install -y unzip git libzip-dev \
    && docker-php-ext-install zip

COPY . /app
WORKDIR /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

CMD php artisan serve --host=0.0.0.0 --port=$PORT
