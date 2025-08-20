#!/bin/bash

echo "☁️ Fixing Laravel permissions for cloud server..."

# Get container name from command line argument or use default
CONTAINER_NAME=${1:-"shokoofeh-app-prod"}

echo "📦 Working with container: $CONTAINER_NAME"

# Fix storage permissions
echo "📁 Fixing storage permissions..."
docker exec -it $CONTAINER_NAME sh -c "
    # Check if directories exist and create them if needed
    if [ ! -d '/var/www/storage/framework/sessions' ]; then
        mkdir -p /var/www/storage/framework/sessions
        echo 'Created sessions directory'
    fi

    if [ ! -d '/var/www/storage/framework/views' ]; then
        mkdir -p /var/www/storage/framework/views
        echo 'Created views directory'
    fi

    if [ ! -d '/var/www/storage/framework/cache' ]; then
        mkdir -p /var/www/storage/framework/cache
        echo 'Created cache directory'
    fi

    if [ ! -d '/var/www/storage/framework/testing' ]; then
        mkdir -p /var/www/storage/framework/testing
        echo 'Created testing directory'
    fi

    if [ ! -d '/var/www/storage/logs' ]; then
        mkdir -p /var/www/storage/logs
        echo 'Created logs directory'
    fi

    if [ ! -d '/var/www/bootstrap/cache' ]; then
        mkdir -p /var/www/bootstrap/cache
        echo 'Created bootstrap/cache directory'
    fi

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

# Clear Laravel caches
echo "🧹 Clearing Laravel caches..."
docker exec -it $CONTAINER_NAME php /var/www/artisan config:clear
docker exec -it $CONTAINER_NAME php /var/www/artisan cache:clear
docker exec -it $CONTAINER_NAME php /var/www/artisan view:clear

echo "🎉 All done! Laravel permissions have been fixed for cloud server."
echo "💡 You can now run Laravel commands without permission errors."
