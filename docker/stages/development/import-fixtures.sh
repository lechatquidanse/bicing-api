#!/usr/bin/env bash

docker exec bicing-api_db_1 unzip /var/data/fixtures.zip -d /var/data
docker exec bicing-api_db_1 psql -d symfony -U symfony -f /var/data/symfony_public_station.sql > /dev/null
docker exec bicing-api_db_1 psql -d symfony -U symfony -f /var/data/symfony_public_station_state.sql > /dev/null
docker exec bicing-api_db_1 rm /var/data/symfony_public_station.sql
docker exec bicing-api_db_1 rm /var/data/symfony_public_station_state.sql
