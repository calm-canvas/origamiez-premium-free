#!/bin/sh


# docker exec -it $(docker ps -a | grep origamiez | cut -c1-4) bash

# password: secret
docker exec -it $(docker ps -a | grep origamiez | cut -c1-4) apt update &&
docker exec -it $(docker ps -a | grep origamiez | cut -c1-4) apt install -y default-mysql-client &&
docker exec -it $(docker ps -a | grep origamiez | cut -c1-4) /tmp/snapshot/restore.sh &&
docker exec -it $(docker ps -a | grep origamiez | cut -c1-4) /tmp/snapshot/composer.sh