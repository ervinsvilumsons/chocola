FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libonig-dev libxml2-dev \
    && docker-php-ext-install mbstring xml

WORKDIR /var/www/html

COPY composer.json ./

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

COPY . .

EXPOSE 9000

CMD ["php-fpm"]