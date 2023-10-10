SHELL=bash
SOURCE_DIR = $(shell pwd)
BIN_DIR = ${SOURCE_DIR}/bin
COMPOSER = composer

define printSection
	@printf "\033[36m\n==================================================\n\033[0m"
	@printf "\033[36m $1 \033[0m"
	@printf "\033[36m\n==================================================\n\033[0m"
endef

.PHONY: all
all: install quality test test-dependencies

.PHONY: ci
ci: quality test

.PHONY: install
install: clean-vendor composer-install

.PHONY: quality
quality: cs-ci

.PHONY: quality-fix
quality-fix: cs-fix

.PHONY: test
test: atoum

.PHONY: cs
cs:
	${BIN_DIR}/php-cs-fixer fix --dry-run --stop-on-violation --diff

.PHONY: cs-fix
cs-fix:
	${BIN_DIR}/php-cs-fixer fix

.PHONY: cs-ci
cs-ci:
	${BIN_DIR}/php-cs-fixer fix --ansi --dry-run --using-cache=no --verbose

.PHONY: clean-vendor
clean-vendor:
	$(call printSection,CLEAN-VENDOR)
	rm -f ${SOURCE_DIR}/composer.lock
	rm -rf ${SOURCE_DIR}/vendor

.PHONY: composer-install
composer-install: ${SOURCE_DIR}/vendor/composer/installed.json

${SOURCE_DIR}/vendor/composer/installed.json:
	$(call printSection,COMPOSER INSTALL)
	$(COMPOSER) --no-interaction install --ansi --no-progress --prefer-dist

.PHONY: atoum
atoum:
	$(call printSection,TEST atoum)
	${BIN_DIR}/atoum

