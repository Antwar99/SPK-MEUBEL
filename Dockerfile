# Gunakan image PHP dengan FPM
FROM php:8.2-fpm

# Install ekstensi dan dependency sistem
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip gd bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Salin semua file ke container
COPY . .

# Link log Laravel ke stdout agar bisa dilihat di Railway log viewer
RUN ln -sf /dev/stdout /var/www/storage/logs/laravel.log

# Install dependensi Laravel
RUN composer install --no-dev --optimize-autoloader

# Jalankan perintah Laravel yang dibutuhkan
RUN php artisan config:clear \
    && php artisan cache:clear \
    && php artisan view:clear \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Set permission untuk storage dan bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Jalankan migrate pakai --force agar tidak interaktif (dan hindari gagal build)
RUN php artisan migrate --force || true

# Railway membutuhkan port 8080
EXPOSE 8080

# Jalankan Laravel menggunakan built-in server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
