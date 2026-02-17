#!/bin/sh
set -e

# Initialize storage directory if empty
# -----------------------------------------------------------
# If the storage directory is empty, copy the initial contents
# and set the correct permissions.
# -----------------------------------------------------------
if [ -d /var/www/storage-init ] && [ ! "$(ls -A /var/www/storage 2>/dev/null)" ]; then
  echo "Initializing storage directory..."
  cp -R /var/www/storage-init/. /var/www/storage
  chown -R www-data:www-data /var/www/storage
fi

# Remove storage-init directory
rm -rf /var/www/storage-init 2>/dev/null || true

# Install composer to /tmp (writable regardless of /var/www ownership)
if [ ! -f /var/www/vendor/autoload.php ]; then
  echo "Installing dependencies..."
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/tmp --filename=composer
  /tmp/composer install --no-interaction --prefer-dist --dev --working-dir=/var/www
  rm -f /tmp/composer
fi

php artisan package:discover

# Run Laravel migrations
# -----------------------------------------------------------
# Ensure the database schema is up to date.
# -----------------------------------------------------------
php artisan migrate --force

# Clear and cache configurations
# -----------------------------------------------------------
# Improves performance by caching config and routes.
# -----------------------------------------------------------
php artisan config:cache
php artisan route:cache

# Run the default command
exec "$@"

