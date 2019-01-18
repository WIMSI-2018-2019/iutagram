# Import et nommage
FROM php:7.3-alpine AS app

# Installation de l'extension
RUN docker-php-ext-install pdo_mysql

VOLUME /var

# Fin du Dockerfile
RUN apk add --no-cache libzip-dev && docker-php-ext-install zip
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
