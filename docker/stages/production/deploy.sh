#!/usr/bin/env bash

# Prepare environment file and docker-compose
envsubst < ./docker/stages/production/.env.dist > ./docker/stages/production/.env
envsubst < ./docker/stages/production/docker-compose.yml.dist > ./docker/stages/production/docker-compose.yml

# Prepare ssh connection with production server
eval $(ssh-agent -s)
echo "${DEPLOY_PRODUCTION_SSH_KEY}" | tr -d '\r' | ssh-add - > /dev/null
mkdir -p ~/.ssh
chmod 700 ~/.ssh

# Copy environment file and docker-compose to production server
scp -o 'StrictHostKeyChecking no' ./docker/stages/production/.env ${SERVER_PRODUCTION}:/var/www/bicing-api/
scp -o 'StrictHostKeyChecking no' ./docker/stages/production/docker-compose.yml ${SERVER_PRODUCTION}:/var/www/bicing-api/
scp -o 'StrictHostKeyChecking no' ./docker/nginx/bicing-api.conf ${SERVER_PRODUCTION}:/var/www/bicing-api/

# Run commands to update docker containers and run migrations
ssh -o 'StrictHostKeyChecking no' ${SERVER_PRODUCTION} 'docker login -u ${REGISTRY_PRODUCTION_LOGIN} -p ${REGISTRY_PRODUCTION_PASSOWRD} registry.gitlab.com'
ssh -o 'StrictHostKeyChecking no' ${SERVER_PRODUCTION} 'docker-compose -f /var/www/bicing-api/docker-compose.yml up -d'
ssh -o 'StrictHostKeyChecking no' ${SERVER_PRODUCTION} 'docker-compose -f /var/www/bicing-api/docker-compose.yml run --rm php bin/console do:mi:mi -n'
ssh -o 'StrictHostKeyChecking no' ${SERVER_PRODUCTION} 'docker logout registry.gitlab.com'

# Clean
rm -rf ~/.ssh
