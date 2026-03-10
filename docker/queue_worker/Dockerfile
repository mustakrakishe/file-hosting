FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update
RUN apt-get install -y libzip-dev unzip
RUN docker-php-ext-install pdo_mysql

CMD ["php", "artisan", "queue:work"]
