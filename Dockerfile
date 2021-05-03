# PHP extension installer
FROM mlocati/php-extension-installer:1.2.24 as extension-installer

# Build php and nginx unit
FROM docker.io/nginx/unit:1.22.0-php8.0 as build

SHELL ["/bin/bash", "-o", "pipefail", "-c"]
COPY --from=extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions opcache apcu intl amqp

COPY unit.conf.json /docker-entrypoint.d/unit.conf.json

# Install composer packages
FROM composer:2.0.11 as vendor

ARG ENVIRONMENT

COPY src /app/src/
COPY composer.json composer.lock /app/

RUN set -ex \
    && if [ "${ENVIRONMENT}" = "prod" ]; \
        then composer install --ignore-platform-reqs --no-ansi --no-autoloader --no-interaction --no-scripts --no-dev; \
        else composer install --ignore-platform-reqs --no-ansi --no-autoloader --no-interaction --no-scripts; \
    fi \
    && composer dump-autoload --optimize --classmap-authoritative \
    && composer check-platform-reqs

# Install node modules
FROM node:15.11.0-alpine3.13 as node

WORKDIR /home/node/app

COPY assets /home/node/app/assets
COPY yarn.lock webpack.config.js package.json /home/node/app/
RUN yarn install && yarn build

# Dev environment
FROM build as dev

ARG ENVIRONMENT

WORKDIR /var/www/html

COPY bin/console bin/console
COPY config config
COPY public public
COPY src src
COPY templates templates
COPY --from=vendor /app/vendor/ vendor
COPY --from=node /home/node/app/public/build/ public/build

SHELL ["/bin/bash", "-o", "pipefail", "-c"]
RUN set -ex \
    && chown www-data:www-data /var/www/html \
    && echo "APP_SECRET=$(tr -dc A-Za-z0-9 < /dev/urandom | head -c 32)" >> .env \
    && echo "APP_ENV=${ENVIRONMENT}" >> .env \
    && php bin/console cache:warmup --env=${ENVIRONMENT}

# Prod environment
FROM dev as prod

RUN rm -rf \
    config/packages/dev \
    config/packages/test \
    config/routes/dev \
    config/routes/test \
    config/modules/dev \
    config/modules/test \
    config/modules/routes/dev \
    config/modules/routes/test

EXPOSE 80
