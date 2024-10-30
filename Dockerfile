FROM php:8.3-fpm

WORKDIR /code

COPY . .

EXPOSE 8080
