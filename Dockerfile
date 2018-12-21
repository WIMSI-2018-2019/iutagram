# Import et nommage
FROM php:7.3-alpine AS app

# Installation de l'extension
RUN docker-php-ext-install pdo_mysql
