# Base image
FROM dunglas/frankenphp:1.3.3-php8.2.26

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install dependencies
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        zip \
        unzip \
        openssh-server \
        netcat-openbsd \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --optimize-autoloader --no-dev

# Generate application key
RUN php artisan key:generate

# Link storage
RUN php artisan storage:link

# Set permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www
RUN chmod -R +x /var/www

# Expose application port
EXPOSE 8000

# Command to run the application
CMD ["frankenphp", "php-server", "-l", "0.0.0.0:8000" ,"-r", "/var/www/public"]
