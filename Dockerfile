# syntax=docker/dockerfile:1

# --- Build Stage ---
FROM php:8.4-fpm-alpine AS build

# Install system dependencies
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    bash \
    oniguruma-dev \
    icu-dev \
    shadow

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    intl \
    gd

# Install Composer
COPY --link --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Copy application code
COPY --link . /app

WORKDIR /app

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# --- Final Stage ---
FROM php:8.4-fpm-alpine AS final

# Create non-root user
RUN addgroup -S appgroup && adduser -S appuser -G appgroup

# Install system dependencies (runtime only)
RUN apk add --no-cache \
    libpng \
    libjpeg-turbo \
    libwebp \
    libzip \
    oniguruma \
    icu

# Copy built app from build stage
COPY --link --from=build /app /app

WORKDIR /app

# Set permissions for storage and bootstrap/cache
RUN chown -R appuser:appgroup storage bootstrap/cache

USER appuser

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
