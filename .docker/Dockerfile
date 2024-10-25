# Stage 1: Use Composer image to get Composer
FROM composer:latest as composer

# Stage 2: Use PHP FPM base image
FROM php:8.3.4-fpm

# Install necessary packages and PHP extensions
RUN apt-get update -y && \
    apt-get install -y \
        libzip-dev \
        unzip \
        && docker-php-ext-install \
            pdo_mysql \
            zip \
        && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy Composer from the first stage
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# Set the working directory
WORKDIR /var/www/php

# Start PHP-FPM
CMD ["php-fpm"]
