FROM php:7.3-fpm

RUN apt-get update \
    && apt-get install -y libzip-dev
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_mysql mysqli mbstring

COPY composer.json /var/www

WORKDIR /var/www

COPY ./work /var/www

COPY ./php/php.ini-development /usr/local/etc/php/php.ini
COPY . /var/www

RUN composer install

# CMD ["php", "-S", "0.0.0.0:8000", "-t", "./work/public"]
# CMD ["vendor/bin/heroku-php-nginx","./work/public"]




# RUN apk --update add tzdata && \
#     cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
#     apk del tzdata && \
#     rm -rf /var/cache/apk/*

# RUN docker-php-ext-install pdo pdo_mysql mysqli mbstring

# RUN apt-get update \
#     && apt-get install -y libzip-dev
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# RUN docker-php-ext-install zip

# COPY composer.json /var/www

# WORKDIR /var/www

# COPY ./php/php.ini-development /usr/local/etc/php/php.ini
# COPY . /var/www


# RUN composer install
