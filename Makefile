# The default environment file
ENVIRONMENT_FILE=$(shell pwd)/.env

# The default project directory
PROJECT_DIRECTORY=$(shell pwd)

composer-install:
	- docker exec -ti kolik-market-api composer install

optimize:
	- docker exec -ti kolik-market-api php artisan optimize

clean:
	- docker exec -ti kolik-market-api php artisan optimize:clear

clean-dependencies:
	- rm -rf vendor

php-fixer:
	- docker exec -ti kolik-market-api vendor/bin/pint

swagger:
	- docker exec -ti kolik-market-api php artisan l5-swagger:generate

psalm:
	- docker exec -ti kolik-market-api vendor/bin/psalm

check-env:
ifeq (,$(wildcard ./.env))
	cp .env.example .env
endif
