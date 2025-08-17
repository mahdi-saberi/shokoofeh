#!/bin/sh

# Startup script برای اجرای همزمان nginx و PHP-FPM
# این script هر دو سرویس را در background اجرا می‌کند

set -e

echo "🚀 شروع سرویس‌های Laravel + Nginx..."

# ایجاد دایرکتوری‌های Laravel (قبل از تنظیم مجوزها)
echo "📁 ایجاد دایرکتوری‌های Laravel..."
mkdir -p /var/www/storage/framework/cache
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/framework/testing
mkdir -p /var/www/storage/logs
mkdir -p /var/www/bootstrap/cache

# تنظیم مجوزهای storage
echo "📁 تنظیم مجوزهای storage..."
chown -R www:www /var/www/storage
chmod -R 775 /var/www/storage

# تنظیم مجوزهای bootstrap/cache
echo "🔐 تنظیم مجوزهای bootstrap/cache..."
chown -R www:www /var/www/bootstrap/cache
chmod -R 775 /var/www/bootstrap/cache

# تنظیم مجوزهای دایرکتوری‌های cache
echo "🔐 تنظیم مجوزهای cache..."
chown -R www:www /var/www/storage/framework
chmod -R 775 /var/www/storage/framework

# ایجاد دایرکتوری‌های مورد نیاز (فقط اگر مجوز داریم)
echo "📁 ایجاد دایرکتوری‌های مورد نیاز..."
mkdir -p /var/log/nginx 2>/dev/null || echo "⚠️ نتوانست دایرکتوری nginx logs ایجاد کند"
mkdir -p /var/lib/nginx 2>/dev/null || echo "⚠️ نتوانست دایرکتوری nginx lib ایجاد کند"
mkdir -p /run/nginx 2>/dev/null || echo "⚠️ نتوانست دایرکتوری nginx run ایجاد کند"

# تنظیم مجوزها فقط اگر مجوز داریم
if [ -w /var/log/nginx ]; then
    chown www:www /var/log/nginx 2>/dev/null || echo "⚠️ نتوانست مالکیت nginx logs را تغییر دهد"
fi

if [ -w /var/lib/nginx ]; then
    chown www:www /var/lib/nginx 2>/dev/null || echo "⚠️ نتوانست مالکیت nginx lib را تغییر دهد"
fi

if [ -w /run/nginx ]; then
    chown www:www /run/nginx 2>/dev/null || echo "⚠️ نتوانست مالکیت nginx run را تغییر دهد"
fi

# بررسی نام command PHP-FPM
echo "🔍 بررسی نام command PHP-FPM..."
if command -v php-fpm82 >/dev/null 2>&1; then
    PHP_FPM_CMD="php-fpm82"
elif command -v php-fpm >/dev/null 2>&1; then
    PHP_FPM_CMD="php-fpm"
elif command -v php82-fpm >/dev/null 2>&1; then
    PHP_FPM_CMD="php82-fpm"
else
    echo "❌ PHP-FPM command یافت نشد"
    echo "🔍 بررسی package های نصب شده:"
    apk list --installed | grep php
    exit 1
fi

echo "✅ PHP-FPM command یافت شد: ${PHP_FPM_CMD}"

# شروع PHP-FPM
echo "🐘 شروع PHP-FPM..."
${PHP_FPM_CMD} -D

# بررسی وضعیت PHP-FPM
sleep 2
if ! pgrep -f "${PHP_FPM_CMD}" > /dev/null; then
    echo "❌ خطا در شروع PHP-FPM"
    echo "🔍 بررسی logs:"
    tail -f /var/log/php-fpm.log 2>/dev/null || echo "Log file موجود نیست"
    exit 1
fi
echo "✅ PHP-FPM با موفقیت شروع شد"

# شروع Nginx
echo "🌐 شروع Nginx..."
nginx -g "daemon off;" &

# بررسی وضعیت Nginx
sleep 2
if ! pgrep -f "nginx" > /dev/null; then
    echo "❌ خطا در شروع Nginx"
    echo "🔍 بررسی nginx configuration:"
    nginx -t
    exit 1
fi
echo "✅ Nginx با موفقیت شروع شد"

echo "🎉 تمام سرویس‌ها با موفقیت شروع شدند!"
echo "📊 وضعیت سرویس‌ها:"
echo "  • PHP-FPM: $(pgrep -f "${PHP_FPM_CMD}" | wc -l) process"
echo "  • Nginx: $(pgrep -f "nginx" | wc -l) process"

# Health check endpoint
echo "🏥 Health check endpoint: http://localhost/health"

# نگه داشتن container
echo "⏳ در انتظار درخواست‌ها..."
tail -f /dev/null 