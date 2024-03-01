FROM php:8.2-fpm

LABEL authors="saparbayevzh03@gmail.com"

COPY ./ /var/www/html/

WORKDIR /var/www/html/

# Install packages
RUN apt update -yqq && apt install -y libfreetype6-dev \
    curl g++ build-essential \
    unzip libzip-dev lftp \
    libicu-dev libpq-dev libonig-dev libaio1  \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install php extensions (modules) and composer
RUN docker-php-ext-install pcntl intl opcache pdo pdo_pgsql pgsql mbstring zip exif gd \
    && docker-php-ext-enable opcache

# Setting permissions
RUN chown www-data:www-data -R /var/www/html/storage /var/www/html/bootstrap/cache

ENTRYPOINT ["php-fpm", "-F"]
