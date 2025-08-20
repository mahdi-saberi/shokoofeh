#!/bin/sh

# Set proper permissions for Laravel
echo "Setting proper permissions for Laravel..."

# Create necessary directories if they don't exist
mkdir -p /var/www/laravel-app/storage/framework/sessions
mkdir -p /var/www/laravel-app/storage/framework/views
mkdir -p /var/www/laravel-app/storage/framework/cache
mkdir -p /var/www/laravel-app/storage/framework/testing
mkdir -p /var/www/laravel-app/storage/logs
mkdir -p /var/www/laravel-app/bootstrap/cache

# Set ownership to www user
chown -R www:www /var/www/laravel-app/storage
chown -R www:www /var/www/laravel-app/bootstrap/cache

# Set proper permissions
chmod -R 755 /var/www/laravel-app/storage
chmod -R 755 /var/www/laravel-app/bootstrap/cache

# Set writable permissions for specific directories that need it
chmod -R 775 /var/www/laravel-app/storage/framework/views
chmod -R 775 /var/www/laravel-app/storage/framework/cache
chmod -R 775 /var/www/laravel-app/storage/framework/sessions

echo "Permissions set successfully!"

# Start PHP-FPM in background
echo "Starting PHP-FPM..."
php-fpm82 -D

# Start Nginx in background
echo "Starting Nginx..."
nginx -g "daemon off;" &

# Wait a moment for services to start
sleep 2

# Check if services are running
if ! pgrep -f "php-fpm82" > /dev/null; then
    echo "Error: PHP-FPM failed to start"
    exit 1
fi

if ! pgrep -f "nginx" > /dev/null; then
    echo "Error: Nginx failed to start"
    exit 1
fi

echo "All services started successfully!"

# Keep container running
tail -f /dev/null 