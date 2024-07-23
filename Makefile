### Test related commands
test-unit:
	php ./vendor/bin/phpunit --group unit-test

test-functional:
	php ./vendor/bin/phpunit --group functional-test

test-code-coverage:
	php ./vendor/bin/phpunit --coverage-text
