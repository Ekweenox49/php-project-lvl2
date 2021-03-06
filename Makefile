lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin

install:
	composer install

test:
	composer exec --verbose phpunit tests

test-coverage:
	composer exec -v phpunit tests -- --coverage-clover build/logs/clover.xml
