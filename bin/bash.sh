#!/bin/sh

docker exec -it $(docker ps -a | grep origamiez | cut -c1-4) bash
