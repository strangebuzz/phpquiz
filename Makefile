# Setup ————————————————————————————————————————————————————————————————————————
EXEC_PHP     = php
COMPOSER     = composer
SYMFONY      = $(EXEC_PHP) bin/console
SYMFONY_BIN  = symfony
DOCKER       = docker
DOCKER_COMP  = docker-compose
YARN         = yarn
STAN         = ./vendor/bin/phpstan
PHP_CS_FIXER = ./vendor/bin/php-cs-fixer
PHPUNIT      = ./vendor/bin/simple-phpunit
LE_EXEC      = certbot
.DEFAULT_GOAL := help
.PHONY: assets

## —— 🐘 PhpQuiz Make file 🐘 ——————————————————————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
up: ## Start the docker hub (Postgres,adminer)
	$(DOCKER_COMP) up -d

down: ## Stop the docker hub
	$(DOCKER_COMP) down --remove-orphans

wait-postgres: ## Wait for postgresql to be up
	bin/wait-for-postgres.sh

## —— Symfony binary 💻 ————————————————————————————————————————————————————————
serve: ## Serve the application with HTTPS support
	$(SYMFONY_BIN) serve --daemon --port=8006

unserve: ## Stop the web server
	$(SYMFONY_BIN) server:stop

composer-install: composer.lock ## Install vendors according to the current composer.lock file
	$(COMPOSER) install

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
cc: ## Clear cache
	$(SYMFONY) c:c

fix-perms: ## Fix permissions of all var files
	chmod -R 777 var/*

purge: ## Purge cache and logs
	rm -rf var/cache/* var/logs/*

assets: ## Install assets
	$(SYMFONY) assets:install public --symlink --relative

load-fixtures: ## Build the db, control the schema validity, load fixtures and check the migration status
	$(SYMFONY) doctrine:cache:clear-metadata --flush
	$(SYMFONY) doctrine:database:create --if-not-exists
	$(SYMFONY) doctrine:schema:drop --force
	$(SYMFONY) doctrine:schema:create
	$(SYMFONY) doctrine:schema:validate
	$(SYMFONY) doctrine:fixtures:load -n

install: composer-install assets dev ## Install all the project dependencies

start: up wait-postgres load-fixtures serve ## Start docker, load fixtures and start the web server

stop: down unserve ## Stop docker and the Symfony binary server

## —— Yarn 🐱 / JavaScript —————————————————————————————————————————————————————
dev: ## Rebuild assets for the dev env
	$(YARN) install
	$(YARN) run encore dev

watch: ## Watch files and build assets when needed for the dev env
	$(YARN) run encore dev --watch

build: ## Build assets for production
	$(YARN) run encore production

## —— Coding standards ✨ ——————————————————————————————————————————————————————
lint-cs: ## Lint files with php-cs-fixer
	$(PHP_CS_FIXER) fix --dry-run

fix-cs: ## Fix files with php-cs-fixer
	$(PHP_CS_FIXER) fix

stan: ## Run PHPStan
	$(STAN) analyse -c phpstan.neon --memory-limit 1G

cs: lint-cs stan ## Run all coding standards checks

## —— Tests ✅ —————————————————————————————————————————————————————————————————
test: phpunit.xml.dist ## Run main functional and unit tests
	$(eval filter ?= '.')
	$(PHPUNIT) --filter=$(filter) --stop-on-failure

## —— Deploy & Prod 🚀 —————————————————————————————————————————————————————————
deploy: ## Full no-downtime deployment with EasyDeploy
	$(SYMFONY) deploy -v

le-renew: ## Renew Let's Encrypt HTTPS certificates
	$(LE_EXEC) --apache -d phpquiz.xyz -d www.phpquiz.xyz
