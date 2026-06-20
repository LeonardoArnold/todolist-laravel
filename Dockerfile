FROM tangramor/nginx-php8-fpm:latest

COPY . .

ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV SESSION_DRIVER file

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN chmod -R 775 storage bootstrap/cache

CMD sh -c "php artisan migrate --force; /start.sh"