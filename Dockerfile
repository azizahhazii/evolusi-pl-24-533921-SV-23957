# STAGE 1: Builder (Tahap Membangun)
FROM php:8.3-cli-alpine AS builder

WORKDIR /var/www

# Pasang dependensi build & ekstensi PHP
RUN apk add --no-cache \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    sqlite-dev \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql bcmath

# Copy composer dari official image
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Copy dependensi composer dan install (tanpa dev)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy seluruh kode sumber aplikasi
COPY . .

# Optimize autoloader & generate key
RUN composer dump-autoload --optimize \
    && cp .env.example .env \
    && php artisan key:generate

# STAGE 2: Runner (Tahap Menjalankan Aplikasi)
FROM php:8.3-cli-alpine AS runner

WORKDIR /var/www

# Pasang runtime library minimal yang dibutuhkan ekstensi & healthcheck
RUN apk add --no-cache \
    curl \
    libpng \
    libxml2 \
    sqlite-libs

# Salin ekstensi PHP yang sudah dikompilasi dari Stage Builder
COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Salin kode aplikasi dari Stage Builder
COPY --from=builder /var/www /var/www

# Atur hak akses seluruh direktori ke user www-data
RUN chown -R www-data:www-data /var/www

# Jalankan container sebagai user NON-ROOT
USER www-data

# Konfigurasi HEALTHCHECK menggunakan IP IPv4 spesifik (127.0.0.1)
HEALTHCHECK --interval=5s --timeout=3s --retries=3 \
  CMD curl -f http://127.0.0.1:8000/ || exit 1

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]