#!/bin/bash

cp .env.example .env;
docker compose up -d rabbitmq mysql php nginx;
docker compose exec php composer install --ignore-platform-req=ext-sockets
docker compose exec php php artisan migrate --seed
docker compose exec php php artisan key:generate
docker compose exec php chown -R www-data:www-data storage
docker compose up -d --scale queue_worker=5;

echo "Setup completed!"
