#!/usr/bin/env bash

# Prepare environment file and docker-compose
envsubst < ./docker/production/.env.dist > ./docker/production/.env
envsubst < ./docker/production/docker-compose.production.yml > ./docker/stages/production/docker-compose.yml

# Prepare ssh connection with production server
eval $(ssh-agent -s)
echo "${DEPLOY_PRODUCTION_SSH_KEY}" | tr -d '\r' | ssh-add - > /dev/null
mkdir -p ~/.ssh
chmod 700 ~/.ssh

# Copy environment file and docker-compose to production server
scp -o 'StrictHostKeyChecking no' ./docker/production/.env ${SERVER_PRODUCTION}:/var/www/bicing-api/
scp -o 'StrictHostKeyChecking no' ./docker/production/docker-compose.yml ${SERVER_PRODUCTION}:/var/www/bicing-api/

# Run commands to update docker containers and run migrations
ssh -o "StrictHostKeyChecking no" ${SERVER_PRODUCTION} "docker login -u ${REGISTRY_PRODUCTION_LOGIN} -p ${REGISTRY_PRODUCTION_PASSOWRD} registry.gitlab.com"
ssh -o "StrictHostKeyChecking no" ${SERVER_PRODUCTION} "docker-compose -f /var/www/bicing-api/docker-compose.yml up -d"
ssh -o "StrictHostKeyChecking no" ${SERVER_PRODUCTION} "docker-compose -f /var/www/bicing-api/docker-compose.yml run --rm php bin/console do:mi:mi -n"
ssh -o "StrictHostKeyChecking no" ${SERVER_PRODUCTION} "rm -rf /var/www/bicing-api/var/cache/prod"
ssh -o "StrictHostKeyChecking no" ${SERVER_PRODUCTION} "docker logout registry.gitlab.com"

# Clean
rm -rf ~/.ssh
