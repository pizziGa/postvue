#!/usr/bin/env bash
echo "Running composer"
composer install --no-dev --working-dir=/app

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate:refresh --force

echo "Linking storage..."
php artisan storage:link