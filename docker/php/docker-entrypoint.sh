#!/bin/sh
set -e

if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'bin/console' ]; then
	mkdir -p var/cache var/log

	if [ "$APP_ENV" -= 'dev' ]; then
		composer install --prefer-dist --no-progress --no-suggest --no-interaction
		>&2 echo "Waiting for Postgres to be ready..."
		echo "${DATABASE_URL}"
		until pg_isready --timeout=0 -h db."${APP_DATABASE_NETWORK}"; do
			sleep 1
		done
        bin/console do:mi:mi -n
	fi
fi

exec docker-php-entrypoint "$@"
