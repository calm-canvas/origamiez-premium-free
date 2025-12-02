#!/bin/bash
set -e

docker compose exec -T wordpress /tmp/snapshot/restore.sh
docker compose exec -T wordpress /tmp/snapshot/composer.sh

echo "Installation completed successfully!"