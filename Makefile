
BIN := ./vendor/bin

help:                                            # Displays this list
	@echo; grep -P "^[a-z][a-zA-Z0-9_<> -]+:.*(?=#)" Makefile | sed -E "s/:[^#]*?#?(.*)?/\r\t\t\t\1/" | uniq | sed "s/^/ make /"; echo
	@echo " Usage: make <TARGET> [ARGS=...]"; echo

clean:                                           # Removes generated files
	@rm -rf $(PWD)/tests/reports

dist-clean: clean                                # Removes generated files and ./vendor
	@rm -rf $(PWD)/vendor

install:                                         # Installs ./vendor dependencies
	@composer install $(ARGS)

update:                                          # Updates ./vendor dependencies
	@composer update $(ARGS)

test: .autoload                                  # Executes unit tests
	@XDEBUG_MODE=coverage $(BIN)/phpunit -c ./tests/phpunit.xml tests $(ARGS) && echo "View in browser: <\e[32mfile://$(PWD)/tests/reports/coverage/index.html\e[0m>"

bench: .autoload                                 # Runs benchmarks
	@$(BIN)/phpbench run --report=aggregate tests/bench/ $(ARGS)

sniff: .autoload                                 # Runs linter on source and tests
	@$(BIN)/phpcs -s --standard=phpcs.xml ./src/ ./tests/unit $(ARGS)

sniff-fix: .autoload                             # Tries to fix linter complaints
	@$(BIN)/phpcbf --standard=phpcs.xml ./src/ ./tests/unit $(ARGS)

analyse: .autoload                               # Performs static analysis
	@$(BIN)/psalm --no-cache --no-suggestions --monochrome --no-progress $(ARGS) | perl -0pe "s/-{3,}\s+([^\!]+)\!\s+-{3,}\s+/\1.\n/"

.autoload:                                       # Creates the autoloader
	@composer -q dumpautoload
