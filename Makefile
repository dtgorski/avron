
BIN := ./vendor/bin

help:                                            # Displays this list
	@echo; grep -P "^[a-z][a-zA-Z0-9_<> -]+:.*(?=#)" Makefile | sed -E "s/:[^#]*?#?(.*)?/\r\t\t\t\1/" | uniq | sed "s/^/ make /"; echo
	@echo " Usage: make <TARGET> [ARGS=...]"; echo

clean:                                           # Removes generated files
	@rm -rf $(PWD)/tests/reports

dist-clean: clean                                # Removes generated files and ./vendor
	@rm -rf $(PWD)/vendor

install: dist-clean                              # Installs ./vendor dependencies
	@composer validate --strict
	@composer install $(ARGS)

update: clean                                    # Updates ./vendor dependencies
	@composer update $(ARGS)

test: clean .autoload                            # Executes unit tests
	@XDEBUG_MODE=coverage $(BIN)/phpunit -c ./tests/phpunit.xml $(ARGS) && if [ -t 1 ]; then echo "\nView in browser: <\e[32mfile://$(PWD)/tests/reports/coverage/index.html\e[0m>"; fi

sniff: clean .autoload                           # Runs linter on source and tests
	@$(BIN)/phpcs -s --standard=phpcs.xml ./src/ ./tests/unit $(ARGS)

sniff-fix: clean .autoload                       # Tries to fix linter complaints
	@$(BIN)/phpcbf --standard=phpcs.xml ./src/ ./tests/unit $(ARGS)

analyse: clean .autoload                         # Performs static analysis
	@$(BIN)/psalm --no-cache --no-suggestions --monochrome --no-progress $(ARGS)

.autoload:                                       # Creates the autoloader
	@composer -q dumpautoload
