#!/bin/sh
set -eu
: "${APP_KEY:?Set a persistent APP_KEY in your hosting environment}"
if [ "$#" -gt 0 ]; then
    exec "$@"
fi
PORT="${PORT:-8080}"
case "$PORT" in *[!0-9]*|'') echo 'PORT must be numeric' >&2; exit 1;; esac
printf 'Listen %s\n' "$PORT" > /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
php artisan config:cache
php artisan route:cache
php artisan view:cache
chown -R www-data:www-data storage bootstrap/cache
exec apache2-foreground
