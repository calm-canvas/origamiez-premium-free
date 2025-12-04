#!/bin/sh

TIMESTAMP=$(date +%Y%m%d_%H%M%S)
docker compose exec cli wp db export /tmp/snapshot/backup_${TIMESTAMP}.sql
docker compose exec cli gzip /tmp/snapshot/backup_${TIMESTAMP}.sql
