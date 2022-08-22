install:
	composer install

make setup:
	php src/bootstrap.php

autoload:
	composer dump-autoload

serve:
	php -S localhost:8081 src/server.php