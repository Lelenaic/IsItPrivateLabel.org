FROM node:26 AS ssr

WORKDIR /app

COPY . .

RUN npm ci && npm run build

CMD node bootstrap/ssr/app.js

FROM chialab/php:8.5-apache AS app

COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

COPY . .
COPY --from=ssr /app/public/build /var/www/html/public/build

RUN install-php-extensions redis

RUN composer install --no-dev --no-autoloader --no-scripts --prefer-dist

RUN composer dump-autoload --optimize --no-dev \
    && php artisan filament:optimize

RUN chown -R www-data:www-data .

COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

ENTRYPOINT ["start.sh"]
