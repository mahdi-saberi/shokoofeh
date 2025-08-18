#!/bin/bash

# Auto-fix Laravel permissions script
# This script can be added to crontab to run automatically

CONTAINER_NAME="shokoofeh-app-prod"
LOG_FILE="/tmp/laravel-permissions.log"

echo "$(date): Starting auto-fix permissions..." >> $LOG_FILE

# Check if container is running
if ! docker ps | grep -q $CONTAINER_NAME; then
    echo "$(date): Container $CONTAINER_NAME is not running" >> $LOG_FILE
    exit 1
fi

# Fix permissions
docker exec $CONTAINER_NAME sh -c "
    # Create necessary directories
    mkdir -p /var/www/storage/framework/{sessions,views,cache,testing}
    mkdir -p /var/www/storage/logs
    mkdir -p /var/www/bootstrap/cache

    # Set ownership to www user
    chown -R www:www /var/www/storage
    chown -R www:www /var/www/bootstrap/cache

    # Set proper permissions with sticky bit for views directory
    chmod -R 775 /var/www/storage
    chmod -R 775 /var/www/bootstrap/cache

    # Set special permissions for views directory (sticky bit + group write)
    chmod 1775 /var/www/storage/framework/views
    chmod g+w /var/www/storage/framework/views

    # Make sure web server can write to these directories
    chmod -R 775 /var/www/storage/framework/cache
    chmod -R 775 /var/www/storage/framework/sessions

    echo 'Permissions fixed successfully!'
" >> $LOG_FILE 2>&1

echo "$(date): Auto-fix permissions completed" >> $LOG_FILE
