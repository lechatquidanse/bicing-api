.DEFAULT_GOAL := help
.SILENT:
.PHONY: vendor

## Colors
COLOR_RESET   = \033[0m
COLOR_INFO    = \033[32m
COLOR_COMMENT = \033[33m

## Help
help:
	printf "${COLOR_COMMENT}Usage:${COLOR_RESET}\n"
	printf " make [target]\n\n"
	printf "${COLOR_COMMENT}Available targets:${COLOR_RESET}\n"
	awk '/^[a-zA-Z\-\_0-9\.@]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf " ${COLOR_INFO}%-16s${COLOR_RESET} %s\n", helpCommand, helpMessage; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)

##################
# Useful targets #
##################

## Install all install_* requirements and launch project.
install: env_file env_build install_vendor install_db

## Run project, install vendors and run migrations.
run: env_run install_vendor install_db

## Stop project.
stop:
	docker-compose stop

## Down project and remove volumes (databases).
down:
	docker-compose down -v --remove-orphans

## Run all quality assurance tools (tests and code inspection).
qa: code_static_analysis code_fixer code_detect code_correct test_spec test test_behaviour

## Truncate database and import fixtures.
fixtures: down run import_dev

########
# Code #
########

## Run codesniffer to correct violations of a defined coding project standards.
code_correct:
	docker-compose exec php bin/phpcs --standard=PSR2 src

## Run codesniffer to detect violations of a defined coding project standards.
code_detect:
	docker-compose exec php bin/phpcbf --standard=PSR2 src tests

## Run cs-fixer to fix php code to follow project standards.
code_fixer:
	docker-compose exec php bin/php-cs-fixer fix

## Run PHPStan to find errors in code.
code_static_analysis:
	docker-compose exec php bin/phpstan analyse src --level max

###############
# Environment #
###############

## Launch and build docker environment.
env_build:
	docker-compose up -d

## Set defaut environment variables by copying env.dist file as .env.
env_file:
	cp .env.dist .env

## Launch docker environment.
env_run:
	docker-compose up -d

###############
# Import Data #
###############

## Import fixtures.
import_dev:
	./docker/stages/development/import-fixtures.sh

## Import stations states from bicing.cat provider.
import_states:
	docker-compose exec php bin/console bicing-api:import:stations-states

## Import stations from bicing.cat provider.
import_stations:
	docker-compose exec php bin/console bicing-api:import:stations

###########
# Install #
###########

## Run database migration.
install_db:
	docker-compose run --rm php bin/console do:mi:mi -n

## Run test database migration.
install_db_test:
	docker-compose exec php bin/console do:mi:mi -n --env=test

## Install vendors.
install_vendor:
	docker-compose run --rm php composer install --prefer-dist --no-scripts --no-progress --no-suggest

########
# Test#
########

## Run unit&integration tests with pre-installing test database.
test: install_db_test test_unit

## Run behaviour tests.
test_behaviour:
	docker-compose exec php bin/behat

## Run unit&integration tests.
test_unit:
	docker-compose exec php bin/simple-phpunit

## Run php spect tests.
test_spec:
	docker-compose exec php bin/phpspec run
