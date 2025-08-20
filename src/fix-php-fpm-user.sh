#!/bin/bash

echo "🔧 Fixing PHP-FPM user configuration..."

# Get container name from command line argument or use default
CONTAINER_NAME=${1:-"shokoofeh-app-prod"}

echo "📦 Working with container: $CONTAINER_NAME"

# Fix PHP-FPM user configuration
echo "🐘 Fixing PHP-FPM user configuration..."
docker exec -it $CONTAINER_NAME sh -c "
    # Change PHP-FPM user from 'nobody' to 'www'
    sed -i 's/user = nobody/user = www/g' /etc/php82/php-fpm.d/www.conf
    sed -i 's/group = nobody/group = www/g' /etc/php82/php-fpm.d/www.conf

    echo '✅ PHP-FPM user changed from nobody to www'
"

# Restart PHP-FPM
echo "🔄 Restarting PHP-FPM..."
docker exec -it $CONTAINER_NAME sh -c "
    pkill php-fpm82
    sleep 2
    php-fpm82 -D
    echo '✅ PHP-FPM restarted with www user'
"

# Fix permissions
echo "📁 Fixing storage permissions..."
docker exec -it $CONTAINER_NAME sh -c "
    # Create necessary directories (one by one to avoid brace expansion issues)
    mkdir -p /var/www/storage/framework/sessions
    mkdir -p /var/www/storage/framework/views
    mkdir -p /var/www/storage/framework/cache
    mkdir -p /var/www/storage/framework/testing
    mkdir -p /var/www/storage/logs
    mkdir -p /var/www/bootstrap/cache

    # Set ownership to www user
    chown -R www:www /var/www/storage
    chown -R www:www /var/www/bootstrap/cache

    # Set secure permissions (755 for directories, 775 for writable areas)
    chmod -R 755 /var/www/storage
    chmod -R 755 /var/www/bootstrap/cache

    # Set writable permissions for specific directories that need it
    chmod -R 775 /var/www/storage/framework/views
    chmod -R 775 /var/www/storage/framework/cache
    chmod -R 775 /var/www/storage/framework/sessions

    echo '✅ Permissions fixed successfully with secure access (755/775)!'
"

echo "🎉 All done! PHP-FPM now runs as www user with secure permissions."
echo "💡 You can now run Laravel commands without permission errors."
