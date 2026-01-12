#!/bin/bash
set -e

echo "=== Starting Deployment ==="

echo "1. Installing dependencies..."
composer install --no-dev --optimize-autoloader

echo "2. Generating app key if not exists..."
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

echo "3. Caching configuration..."
php artisan config:cache
php artisan route:cache

echo "4. Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=8080
