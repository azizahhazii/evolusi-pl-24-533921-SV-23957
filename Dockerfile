# 1. Gunakan Base Image PHP resmi dengan tag spesifik (Alpine agar ringan)
FROM php:8.3-cli-alpine

# 2. Tentukan folder kerja di dalam container
WORKDIR /var/www

# 3. Pasang dependensi sistem & ekstensi PHP yang dibutuhkan Laravel
RUN apk add --no-cache \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    sqlite-dev \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql bcmath

# 4. Salin Composer dari image resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. SALIN DULU DAFTAR DEPENDENSI (Trik Cache Docker)
COPY composer.json composer.lock ./

# 6. Pasang dependensi PHP tanpa kode aplikasi dulu
RUN composer install --no-dev --no-scripts --no-autoloader

# 7. BARU SALIN SELURUH KODE APLIKASI (Layer ini yang akan berubah jika kode diedit)
COPY . .

# 8. Optimize autoloader & persiapkan file .env bawaan
RUN composer dump-autoload --optimize \
    && cp .env.example .env \
    && php artisan key:generate

# 9. Informasi port yang digunakan
EXPOSE 8000

# 10. Perintah saat container dinyalakan
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]