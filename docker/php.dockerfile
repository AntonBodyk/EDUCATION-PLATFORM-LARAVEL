FROM php:8.2-fpm-alpine

# Установка необходимых PHP расширений
RUN apk --no-cache update \
    && apk --no-cache add \
        autoconf \
        g++ \
        make \
        openssl-dev

# Установка расширений PHP
RUN pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pdo pdo_mysql

# Установка расширений gd и zip
#RUN apk --update add \
#    freetype-dev \
#    libjpeg-turbo-dev \
#    libpng-dev \
#    zlib-dev \
#    libzip-dev \
#    && docker-php-ext-configure gd --with-freetype --with-jpeg \
#    && docker-php-ext-install -j$(nproc) gd zip

# Копирование Composer из официального образа
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY php/php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www

CMD ["php-fpm"]
