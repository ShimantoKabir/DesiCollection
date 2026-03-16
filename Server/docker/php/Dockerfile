FROM php:8.1-fpm

# 1. Install system dependencies
# Added libssl-dev and libzip-dev for better compatibility with FTP and Zip
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Install PHP extensions
# Added 'zip' extension which is often required by Composer/Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 3. Get latest Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /var/www

# 5. Fix permissions BEFORE switching users (if applicable)
# We create the directories first to ensure they exist before we change ownership
RUN mkdir -p /var/www/storage/framework/cache/data \
    && mkdir -p /var/www/storage/framework/sessions \
    && mkdir -p /var/www/storage/framework/views \
    && mkdir -p /var/www/bootstrap/cache

# Change ownership to www-data (the user PHP-FPM runs as)
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# 6. Optimized setup: Keep as root for ownership, or switch to www-data for security
# If you use 'USER www-data', ensure your docker-compose.yml volumes don't overwrite these permissions.