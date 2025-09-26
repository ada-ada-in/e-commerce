FROM php:8.2-apache

WORKDIR /var/www/html

# Instal dependensi dan langsung bersihkan cache
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql mysqli intl zip mbstring \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Layer ini akan di-cache selama composer.json/lock tidak berubah
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Layer ini hanya menyalin kode aplikasi Anda, tanpa folder "vendor" atau ".git"
COPY . .

RUN chown -R www-data:www-data /var/www/html/writable

EXPOSE 80