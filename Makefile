ifndef APP_ENV
include .env
endif

.DEFAULT_GOAL := help
.PHONY: help
help:
	@grep -E '^[a-zA-Z-]+:.*?## .*$$' Makefile | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "[32m%-15s[0m %s\n", $$1, $$2}'

###> symfony/framework-bundle ###
CONSOLE := $(shell which bin/console)
sf_console:
ifndef CONSOLE
	@printf "Run \033[32mcomposer require cli\033[39m to install the Symfony console.\n"
endif

cache-clear: ## Clears the cache
ifdef CONSOLE
	@bin/console cache:clear --no-warmup
else
	@rm -rf var/cache/*
endif
.PHONY: cache-clear

cache-warmup: cache-clear ## Warms up an empty cache
ifdef CONSOLE
	@bin/console cache:warmup
else
	@printf "Cannot warm up the cache (needs symfony/console).\n"
endif
.PHONY: cache-warmup

###> test/spec ###
TEST_SPEC := $(shell which bin/phpspec)
test-spec:
ifdef TEST_SPEC
	@bin/phpspec run
endif
.PHONY: test-spec

###> test/phpunit ###
TEST_PHPUNIT := $(shell which bin/phpunit)
test-unit:
ifdef TEST_PHPUNIT
	@bin/phpunit
endif
.PHONY: test-unit

###> test ###
test: test-spec test-unit
.PHONY: test

install:
	cp .env.dist .env
	docker-compose up -d --build
	docker-compose run --rm php composer install
	docker-compose run --rm php bin/console do:mi:mi -n
	docker-compose run --rm php bin/console do:mi:mi -n --env=test
	docker-compose run --rm php bin/phpspec run
	docker-compose run --rm php bin/phpunit

run:
	docker-compose up -d
	docker-compose run --rm php composer install
	docker-compose run --rm php bin/console do:mi:mi -n
	docker-compose run --rm php bin/console do:mi:mi -n --env=test
	docker-compose run --rm php bin/phpspec run
	docker-compose run --rm php bin/phpunit

down:
	docker-compose down -v --remove-orphans

fixtures:
	docker-compose down -v --remove-orphans
	docker-compose up -d
	docker-compose run --rm php bin/console do:mi:mi -n
	./docker/stages/development/import-fixtures.sh

qa:
	docker-compose run --rm php bin/php-cs-fixer fix
	docker-compose run --rm php bin/phpcbf --standard=PSR2 src tests
	docker-compose run --rm php bin/phpcs --standard=PSR2 src
	docker-compose run --rm php composer install
	docker-compose run --rm php bin/phpspec run
	docker-compose run --rm php bin/phpunit
