#!/bin/sh

docker compose exec --user root cli chown -R www-data:www-data /var/www/html/wp-content &&
docker compose exec cli wp plugin install theme-check &&
docker compose exec cli wp plugin install wordpress-importer





