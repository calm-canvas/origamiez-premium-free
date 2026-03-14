#!/bin/sh

docker compose exec cli wp cache flush
docker compose exec cli wp transient delete --all
