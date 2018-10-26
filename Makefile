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

## Run all quality assurance tools.
qa: code_fixer code_detect code_correct test_spec test test_behaviour

## Truncate database and import fixtures.
fixtures: down run dev_import

###############
# Environment #
###############

## Set defaut environment variables by copying env.dist file as .env.
env_file:
	cp .env.dist .env

## Launch docker environment.
env_run:
	docker-compose up -d

## Launch and build docker environment.
env_build:
	docker-compose up -d

###########
# Install #
###########

## Install vendors.
install_vendor:
	docker-compose run --rm php composer install --prefer-dist --no-autoloader --no-scripts --no-progress --no-suggest

## Run database migration.
install_db:
	docker-compose run --rm php bin/console do:mi:mi -n

## Run test database migration.
install_db_test:
	docker-compose exec php bin/console do:mi:mi -n --env=test

########
# Code #
########

## Run cs-fixer to fix php code to follow project standards.
code_fixer:
	docker-compose exec php bin/php-cs-fixer fix

## Run codesniffer to detect violations of a defined coding project standards.
code_detect:
	docker-compose exec php bin/phpcbf --standard=PSR2 src tests

## Run codesniffer to correct violations of a defined coding project standards.
code_correct:
	docker-compose exec php bin/phpcs --standard=PSR2 src

########
# Test#
########

## Run php spect tests.
test_spec:
	docker-compose exec php bin/phpspec run

## Run unit&integration tests.
test_unit:
	docker-compose exec php bin/simple-phpunit

## Run unit&integration tests with pre-installing test database.
test: install_db_test test_unit

## Run behaviour tests.
test_behaviour:
	docker-compose exec php bin/behat

###############
# Development #
###############

## Import fixtures.
dev_import:
	./docker/stages/development/import-fixtures.sh

