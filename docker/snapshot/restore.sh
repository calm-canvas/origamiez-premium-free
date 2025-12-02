#!/bin/bash

set -a
[ -f /var/www/html/wp-content/themes/origamiez/.env ] && source /var/www/html/wp-content/themes/origamiez/.env
set +a

MYSQL_PWD="${WORDPRESS_DB_PASSWORD}" mysql \
  -h"${WORDPRESS_DB_HOST}" \
  -u"${WORDPRESS_DB_USER}" \
  "${WORDPRESS_DB_NAME}" < /tmp/snapshot/schema.sql