#!/usr/bin/env bash

docker-compose exec db unzip /var/data/fixtures.zip -d /var/data
docker-compose exec db psql -d symfony -U symfony -f /var/data/symfony_public_station.sql > /dev/null
docker-compose exec db psql -d symfony -U symfony -f /var/data/symfony_public_station_state.sql > /dev/null
docker-compose exec db rm /var/data/symfony_public_station.sql
docker-compose exec db rm /var/data/symfony_public_station_state.sql
