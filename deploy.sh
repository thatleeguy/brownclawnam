#!/usr/bin/env bash
# Forge deploy script — paste into Forge's deploy script editor.
# Forge sets these env vars: $FORGE_COMPOSER, $FORGE_PHP, $FORGE_PHP_FPM,
# $FORGE_SITE_BRANCH (and the cwd is the site path).

set -e

git pull origin "${FORGE_SITE_BRANCH:-main}"

# Ensure Laravel runtime directories exist (defence-in-depth — git tracks
# placeholder .gitignore files inside each, but realpath() failures here
# are the most common first-deploy stumble).
mkdir -p \
    storage/framework/views \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/testing \
    storage/logs \
    storage/app/public \
    storage/app/private \
    bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

# First-deploy guard: Laravel's post-autoload script (package:discover) needs
# .env to bootstrap. If Forge's environment editor hasn't been saved yet, seed
# .env from the production example so composer install can complete. Connor
# should still set real values in Forge → Environment after the first deploy.
if [ ! -f .env ]; then
    if [ -f .env.production.example ]; then
        cp .env.production.example .env
    elif [ -f .env.example ]; then
        cp .env.example .env
    fi
fi

# Generate APP_KEY if missing (post-deploy this becomes a no-op).
if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
    "$FORGE_PHP" artisan key:generate --force --no-interaction || true
fi

$FORGE_COMPOSER install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Frontend build
npm ci
npm run build

# Storage symlink (idempotent)
"$FORGE_PHP" artisan storage:link || true

# Cache config & routes & views for prod
"$FORGE_PHP" artisan config:cache
"$FORGE_PHP" artisan route:cache
"$FORGE_PHP" artisan view:cache
"$FORGE_PHP" artisan event:cache

# Run migrations
"$FORGE_PHP" artisan migrate --force

# Restart php-fpm so opcache picks up new code
( flock -w 10 9 || exit 1
    echo 'Restarting FPM...'; sudo -S service "$FORGE_PHP_FPM" reload ) 9>/tmp/fpmlock

# Queue restart (no-op if no queue worker configured yet)
"$FORGE_PHP" artisan queue:restart || true
