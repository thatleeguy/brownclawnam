#!/usr/bin/env bash
# Forge deploy script for brownclawam.ca
# Paste this (or its equivalent) into the Forge deploy script editor.

set -e

cd /home/forge/brownclawam.ca

git pull origin main

$FORGE_COMPOSER install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Frontend build
npm ci
npm run build

# Storage symlink (idempotent)
$FORGE_PHP artisan storage:link || true

# Cache config & routes & views for prod
$FORGE_PHP artisan config:cache
$FORGE_PHP artisan route:cache
$FORGE_PHP artisan view:cache
$FORGE_PHP artisan event:cache

# Run migrations
$FORGE_PHP artisan migrate --force

# Restart php-fpm so opcache picks up new code
( flock -w 10 9 || exit 1
    echo 'Restarting FPM...'; sudo -S service $FORGE_PHP_FPM reload ) 9>/tmp/fpmlock

# Queue restart (no-op if no queue worker configured yet)
$FORGE_PHP artisan queue:restart || true
