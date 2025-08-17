#!/bin/sh

# Docker Entrypoint Script برای Laravel + Nginx
# این script دایرکتوری‌های مورد نیاز را ایجاد می‌کند و سرویس‌ها را شروع می‌کند

set -e

echo "🚀 شروع Shokoofeh App..."

# ایجاد دایرکتوری‌های Laravel
echo "📁 ایجاد دایرکتوری‌های Laravel..."
mkdir -p /var/www/storage/framework/cache
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/framework/testing
mkdir -p /var/www/storage/logs
mkdir -p /var/www/bootstrap/cache

# تنظیم مجوزها
echo "🔐 تنظیم مجوزها..."
chown -R www:www /var/www
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache

# ایجاد دایرکتوری‌های nginx
echo "📁 ایجاد دایرکتوری‌های nginx..."
mkdir -p /var/log/nginx
mkdir -p /var/lib/nginx
mkdir -p /run/nginx

# تنظیم مجوزهای nginx
chown -R www:www /var/log/nginx
chown -R www:www /var/lib/nginx
chown -R www:www /run/nginx

# بررسی PHP-FPM
echo "🔍 بررسی PHP-FPM..."
if command -v php-fpm82 >/dev/null 2>&1; then
    PHP_FPM_CMD="php-fpm82"
elif command -v php-fpm >/dev/null 2>&1; then
    PHP_FPM_CMD="php-fpm"
elif command -v php82-fpm >/dev/null 2>&1; then
    PHP_FPM_CMD="php82-fpm"
else
    echo "❌ PHP-FPM command یافت نشد"
    exit 1
fi

echo "✅ PHP-FPM command: ${PHP_FPM_CMD}"

# شروع PHP-FPM
echo "🐘 شروع PHP-FPM..."
${PHP_FPM_CMD} -D

# بررسی PHP-FPM
sleep 2
if ! pgrep -f "${PHP_FPM_CMD}" > /dev/null; then
    echo "❌ خطا در شروع PHP-FPM"
    exit 1
fi
echo "✅ PHP-FPM شروع شد"

# شروع Nginx
echo "🌐 شروع Nginx..."
nginx -g "daemon off;" &

# بررسی Nginx
sleep 2
if ! pgrep -f "nginx" > /dev/null; then
    echo "❌ خطا در شروع Nginx"
    exit 1
fi
echo "✅ Nginx شروع شد"

echo "🎉 تمام سرویس‌ها شروع شدند!"
echo "🏥 Health check: http://localhost/health"

# نگه داشتن container
exec tail -f /dev/null 