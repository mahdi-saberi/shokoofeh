FROM php:8.2-fpm

# نصب اکستنشن‌های مورد نیاز
RUN apt-get update \
    && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git unzip curl gosu libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install gd pdo pdo_mysql intl

# نصب Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# ایجاد کاربر و گروه برای Laravel
RUN groupadd -g 1000 www \
    && useradd -u 1000 -ms /bin/bash -g www www

# کپی کردن فایل‌های پروژه
COPY ./src /var/www

# تغییر مالکیت فایل‌ها به کاربر www
RUN chown -R www:www /var/www

# تنظیم مجوزهای storage و bootstrap/cache
RUN chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

CMD ["php-fpm"] 