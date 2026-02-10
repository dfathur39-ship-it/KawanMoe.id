#!/bin/sh
set -e

echo "Running Laravel pre-deploy..."

# Generate key if not set (optional, better set in Railway Variables)
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
  echo "Warning: APP_KEY not set. Run: php artisan key:generate --show"
fi

# Run migrations
php artisan migrate --force --no-interaction

# Create storage link if not exists
php artisan storage:link --no-interaction 2>/dev/null || true

# Cache config and routes for production
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

echo "Pre-deploy finished."
