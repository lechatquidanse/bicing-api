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

###> This build command has to be upgraded to avoid exec connection to containers ###
build-bicing:
	cp .env.dist .env
	docker-compose up -d
	docker exec -it bicingapi_php_1 composer install
	docker exec -it bicingapi_php_1 bin/console do:mi:mi -n
