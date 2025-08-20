#!/bin/bash

echo "🔧 Fixing Laravel permissions in Docker container..."

# Get container name from command line argument or use default
CONTAINER_NAME=${1:-"shokoofeh-app"}

echo "📦 Working with container: $CONTAINER_NAME"

# Fix storage permissions
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

# Clear Laravel caches
echo "🧹 Clearing Laravel caches..."
docker exec -it $CONTAINER_NAME php /var/www/artisan config:clear
docker exec -it $CONTAINER_NAME php /var/www/artisan cache:clear
docker exec -it $CONTAINER_NAME php /var/www/artisan view:clear

echo "🎉 All done! Laravel permissions have been fixed."
echo "💡 You can now run Laravel commands without permission errors." 
