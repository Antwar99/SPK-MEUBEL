# Gunakan PHP 8.2 dengan FPM
FROM php:8.2-cli

# Install ekstensi yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    unzip zip curl git libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# Install dependensi Laravel
RUN composer install --no-dev --optimize-autoloader

# Izin folder Laravel
RUN chmod -R 775 storage bootstrap/cache

# Cache konfigurasi
RUN php artisan config:clear && php artisan view:clear && php artisan config:cache && php artisan view:cache

# Jalankan Laravel dev server di Railway port 8080
EXPOSE 8080
CMD php artisan serve --host=0.0.0.0 --port=8080
