#!/bin/bash
set -e

if [ ! -d "vendor" ]; then
    composer install --no-scripts --no-autoloader
fi

until php bin/console doctrine:query:sql 'SELECT 1' > /dev/null 2>&1; do
  >&2 echo "MySQL is unavailable - sleeping"
  sleep 1
done

>&2 echo "MySQL is up - executing migrations"
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load --no-interaction


exec php-fpm
