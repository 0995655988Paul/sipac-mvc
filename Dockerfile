FROM php:8.3-cli

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .

RUN docker-php-ext-install pdo_sqlite \
    && composer install --no-dev --optimize-autoloader --no-interaction \
    && mkdir -p writable/cache writable/logs writable/session writable/uploads writable/debugbar \
    && chmod -R 775 writable

ENV CI_ENVIRONMENT=production
EXPOSE 8080
CMD ["./docker-entrypoint.sh"]
