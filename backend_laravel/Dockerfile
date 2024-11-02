# Sử dụng image PHP có chứa Apache
FROM php:8.2-apache

# Cài đặt các extension cần thiết cho Laravel và kích hoạt mod_rewrite cho Apache
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip \
    && a2enmod rewrite

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy mã nguồn Laravel vào container
COPY . /var/www/html

# Chuyển đến thư mục làm việc
WORKDIR /var/www/html

# Cấp quyền cho thư mục storage và bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Chạy các lệnh khởi tạo
RUN composer install --no-interaction
RUN cp .env.example .env && php artisan key:generate

# Thiết lập thư mục public là thư mục gốc của Apache
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Mở cổng 80 cho Apache
EXPOSE 80
