#!/bin/sh

# The containers are now synchronized with the host user via WWWUSER and WWWGROUP in .env
# This script ensures that wp-content has the correct ownership and permissions.
# Since www-data UID/GID now matches the host user, we can just use the name 'www-data'.

# echo "Setting permissions and ownership for wp-content..."
# docker compose exec --user root wordpress sh -c "chown -R www-data:www-data /var/www/html/wp-content && chmod -R 775 /var/www/html/wp-content"

echo "Installing plugins..."
docker compose exec cli wp plugin install theme-check woocommerce wordpress-importer --activate
