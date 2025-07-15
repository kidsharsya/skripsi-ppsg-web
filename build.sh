#!/usr.bin/env bash
# exit on error
set -o errexit

# Perintah untuk Build
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
npm install
npm run build
php artisan migrate --force
php artisan storage:link