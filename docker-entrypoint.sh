#!/bin/sh

# Set proper permissions for Laravel
echo "Setting proper permissions for Laravel..."

# Create necessary directories if they don't exist
mkdir -p /var/www/storage/framework/{sessions,views,cache,testing}
mkdir -p /var/www/storage/logs
mkdir -p /var/www/bootstrap/cache

# Set ownership to www user
chown -R www:www /var/www/storage
chown -R www:www /var/www/bootstrap/cache

# Set proper permissions
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache

# Make sure the web server can write to these directories
chmod -R 775 /var/www/storage/framework/views
chmod -R 775 /var/www/storage/framework/cache
chmod -R 775 /var/www/storage/framework/sessions

echo "Permissions set successfully!"

# Execute the main command
exec "$@" 