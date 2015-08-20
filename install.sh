#!/bin/bash
set -e

if [[ -z "$1" ]]
then
    echo "You need to specify an environment (dev, test, prod) as first argument";
    exit;
fi;

SF2_ENV="$1";

rm -rf app/cache/*

# Detect composer binary
    if which composer >/dev/null; then
        composer='composer'
    elif which composer.phar >/dev/null; then
        composer='composer.phar'
    else
        # Install composer
        curl -s http://getcomposer.org/installer | php >/dev/null
        composer='php composer.phar'
    fi

    # Install or update packages specified in the lock file
    if [ ! -d vendor ]; then
    	$composer install -o
    fi

# Database
php ./app/console doctrine:database:drop --env=$SF2_ENV --force || true
php ./app/console doctrine:database:create --env=$SF2_ENV
php ./app/console doctrine:schema:create --env=$SF2_ENV
php ./app/console doctrine:mongodb:schema:create --env=$SF2_ENV

# Web folder
php ./app/console assets:install
