COMMIT := $(shell git rev-parse --short=8 HEAD)
ZIP_FILENAME := $(or $(ZIP_FILENAME),"cc-food-truck-build-file.zip")
BUILD_DIR := $(or $(BUILD_DIR),"build")
VENDOR_AUTOLOAD := vendor/autoload.php
NODE_MODULES := node_modules/.package-lock.json

help:  ## Print the help documentation
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: build
build:  ## Build
	git archive --format=zip --output=${ZIP_FILENAME} $(COMMIT)
	mkdir ${BUILD_DIR} && mv ${ZIP_FILENAME} ${BUILD_DIR}/

.PHONY: clean
clean:  ## clean
	rm -rf build dist

$(VENDOR_AUTOLOAD):
	composer install --prefer-dist --no-progress

$(NODE_MODULES):
	npm install

.PHONY: composer
composer: $(VENDOR_AUTOLOAD) ## Runs composer install

.PHONY: npm
npm: $(NODE_MODULES) ## Runs npm install

.PHONY: lint
lint: composer npm ## Lint
	vendor/squizlabs/php_codesniffer/bin/phpcs
	npm run lint
	npm run prettier

.PHONY: lint-fix
lint-fix: composer npm ## Lint Fix
	vendor/squizlabs/php_codesniffer/bin/phpcbf
	npm run lint:fix
	npm run prettier:fix

.PHONY: dev
dev: ## Start dev compose
	docker-compose up
