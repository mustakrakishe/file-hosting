FROM php:8.3-fpm

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN pecl install xdebug-3.3.1
RUN apt-get update
RUN apt-get install -y libzip-dev unzip
RUN docker-php-ext-install pdo_mysql
RUN apt-get install -y cron \
    && echo "* * * * * /usr/local/bin/php /var/www/html/artisan schedule:run >> /var/www/html/storage/logs/cron.log 2>&1" > /etc/cron.d/run_laravel_scheduler \
    && crontab -u www-data /etc/cron.d/run_laravel_scheduler

EXPOSE 9000

CMD cron && php-fpm
