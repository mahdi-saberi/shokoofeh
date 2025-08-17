# Multi-stage Dockerfile برای Laravel + Nginx
# این Dockerfile یک image واحد تولید می‌کند که هم nginx و هم PHP-FPM را دارد

# Stage 1: Build Laravel app
FROM php:8.2-fpm AS app-builder

# نصب اکستنشن‌های مورد نیاز
RUN apt-get update \
    && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git unzip curl gosu libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install gd pdo pdo_mysql intl

# نصب Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# کپی کردن فایل‌های پروژه
COPY ./src /var/www

# نصب dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# تنظیم مجوزها
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Stage 2: Final image with Nginx + PHP-FPM
FROM nginx:1.29.1-alpine

# نصب PHP-FPM و اکستنشن‌های مورد نیاز
RUN apk add --no-cache \
    php82 \
    php82-fpm \
    php82-mysqli \
    php82-pdo \
    php82-pdo_mysql \
    php82-gd \
    php82-intl \
    php82-json \
    php82-mbstring \
    php82-openssl \
    php82-tokenizer \
    php82-xml \
    php82-zip \
    php82-fileinfo \
    php82-curl \
    php82-session \
    php82-phar \
    php82-dom \
    php82-xmlreader \
    php82-xmlwriter \
    php82-simplexml \
    php82-ctype \
    php82-iconv \
    php82-opcache \
    php82-zlib \
    && rm -rf /var/cache/apk/*

# ایجاد symlink برای php command
RUN ln -sf /usr/bin/php82 /usr/local/bin/php

# کپی کردن فایل‌های Laravel
COPY --from=app-builder /var/www /var/www

# ایجاد کاربر و گروه
RUN addgroup -g 1000 www \
    && adduser -u 1000 -G www -s /bin/sh -D www

# ایجاد دایرکتوری‌های مورد نیاز و تنظیم مجوزها
RUN mkdir -p /var/www/storage/framework/cache \
    && mkdir -p /var/www/storage/framework/sessions \
    && mkdir -p /var/www/storage/framework/views \
    && mkdir -p /var/www/storage/framework/testing \
    && mkdir -p /var/www/storage/logs \
    && mkdir -p /var/www/bootstrap/cache \
    && chown -R www:www /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# کپی کردن nginx configuration
COPY nginx.conf /etc/nginx/nginx.conf

# کپی کردن entrypoint script
COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

# Expose port
EXPOSE 80

# Start both services
ENTRYPOINT ["/docker-entrypoint.sh"] 