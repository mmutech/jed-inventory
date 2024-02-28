# Use the official PHP image as a base image
FROM php:7.4-fpm

# Set the working directory in the container
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy project files to the container
COPY . .

# Install project dependencies
RUN composer install

# Expose port 9000 and start PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
