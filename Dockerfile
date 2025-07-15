FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    libzip-dev \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libmcrypt-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Clear and cache config/routes/views
RUN php artisan config:clear && php artisan view:clear
RUN php artisan config:cache && php artisan view:cache

# Fix permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose Railway port
EXPOSE 8080

# Start Laravel server
CMD php artisan serve --host=0.0.0.0 --port=8080
