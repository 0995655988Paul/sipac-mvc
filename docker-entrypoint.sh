#!/bin/sh
set -eu

php spark migrate --all
php spark db:seed DatabaseSeeder
exec php -S 0.0.0.0:"${PORT:-8080}" -t public public/index.php
