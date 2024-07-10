# Menggunakan image resmi PHP dengan versi yang diinginkan
FROM php:8.1-fpm

# Menambahkan tools untuk instalasi ekstensi PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalasi ekstensi PHP yang diperlukan
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Instalasi Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Menyiapkan direktori kerja
WORKDIR /var/www

# Menyalin file composer.json dan composer.lock
COPY composer.json composer.lock ./

# Menjalankan instalasi dependensi dengan Composer
RUN composer install --no-scripts --no-autoloader || cat /var/www/vendor/composer/installed.json

# Menyalin seluruh proyek ke dalam kontainer
COPY . .

# Menjalankan autoload Composer
RUN composer dump-autoload --optimize

# Mengubah kepemilikan direktori storage dan cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Mengexpose port 9000 untuk PHP-FPM
EXPOSE 9000

# Perintah untuk menjalankan PHP-FPM
CMD ["php-fpm"]
