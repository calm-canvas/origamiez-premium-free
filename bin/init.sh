#!/bin/sh

docker compose exec --user root wordpress chmod 755 -R  /var/www/html/wp-content &&
docker compose exec --user root cli chown -R www-data:www-data /var/www/html/wp-content &&
docker compose exec cli wp plugin install theme-check &&
docker compose exec cli wp plugin install wordpress-importer &&
docker compose exec cli wp plugin install regenerate-thumbnails





