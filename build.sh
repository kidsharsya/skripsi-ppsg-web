#!/usr/bin/env bash

echo "🏗 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

echo "🔑 Generating app key..."
php artisan key:generate

echo "📦 Running migrations..."
php artisan migrate --force

echo "📂 Linking storage..."
php artisan storage:link

echo "💡 Building frontend..."
npm install
npm run build

echo "✅ Done!"
