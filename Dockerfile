# Gunakan base image resmi dari PHP dengan server Apache
FROM php:8.2-apache

# Set variabel environment untuk menghindari prompt interaktif saat instalasi
ENV DEBIAN_FRONTEND=noninteractive

# Set direktori kerja di dalam container
WORKDIR /var/www/html

# 1. INSTALASI DEPENDENSI SISTEM
# Pisahkan instalasi dependensi sistem. Layer ini hanya akan di-build ulang
# jika ada perubahan di baris ini.
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. INSTALASI EKSTENSI PHP
# Pisahkan instalasi ekstensi PHP. Ini juga jarang berubah.
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql mysqli intl zip mbstring

# 3. KONFIGURASI APACHE & INSTALASI COMPOSER
# Aktifkan mod_rewrite untuk CodeIgniter
RUN a2enmod rewrite

# Salin Composer dari image resminya (multi-stage build)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# (Opsional) Jika Anda menggunakan file konfigurasi virtual host custom
# Pastikan file ini ada di proyek Anda: docker/apache/000-default.conf
# COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# 4. INSTALASI DEPENDENSI COMPOSER
# Salin hanya file composer dan install dependensi. Layer ini hanya akan
# di-build ulang jika composer.json atau composer.lock berubah.
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# 5. SALIN KODE APLIKASI
# Ini adalah langkah terakhir. Layer ini akan di-build ulang setiap kali
# ada perubahan pada kode Anda.
COPY . .

# 6. ATUR PERIZINAN FOLDER
# Pastikan Apache bisa menulis ke folder 'writable'
RUN mkdir -p /var/www/html/writable
RUN chown -R www-data:www-data /var/www/html/writable
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;
# Expose port 80 dari container
EXPOSE 80