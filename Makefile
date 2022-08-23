install:
	composer install

setup:
	php src/bootstrap.php

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src

lint-fix:
	composer run-script phpcbf -- --standard=PSR12 src

test:
	composer exec --verbose phpunit tests

autoload:
	composer dump-autoload

serve:
	php -S localhost:8081 src/server.php