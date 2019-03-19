# Import et nommage
FROM php:7.3-alpine AS app

# Installation de l'extension
RUN docker-php-ext-install pdo_mysql

VOLUME /var


# Fin du Dockerfile
RUN apk add --no-cache libzip-dev && docker-php-ext-install zip
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# Dockerfile
COPY --from=node:10-alpine /usr/local/bin/node /usr/local/bin/node
COPY --from=node:10-alpine /usr/local/include/node /usr/local/include/node
COPY --from=node:10-alpine /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node:10-alpine /opt/yarn* /opt/yarn

RUN apk add --no-cache libstdc++; \
    ln -vs /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm; \
    ln -vs /opt/yarn/bin/yarn /usr/local/bin/yarn
