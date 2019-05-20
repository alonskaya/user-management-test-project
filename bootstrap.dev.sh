#!/bin/bash

sleep 5

php /var/www/bin/console doctrine:migrations:migrate

php-fpm
