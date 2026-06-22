FROM chialab/php:8.5-apache AS app

COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

COPY . .
RUN composer install --no-dev --no-autoloader --no-scripts --prefer-dist

RUN composer dump-autoload --optimize --no-dev \
    && php artisan package:discover --ansi

RUN chown -R www-data:www-data .

COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

ENTRYPOINT ["start.sh"]
