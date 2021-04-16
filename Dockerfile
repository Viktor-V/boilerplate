# Build php and nginx unit
FROM docker.io/nginx/unit:1.22.0-php8.0 as build

SHELL ["/bin/bash", "-o", "pipefail", "-c"]
RUN set -ex \
    && apt-get update -qq \
    && apt-get install --no-install-recommends -y libicu-dev=63.1-6+deb10u1 \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install opcache \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

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

COPY --from=vendor /app/vendor/ vendor
COPY --from=node /home/node/app/public/build/ public/build
COPY . .

SHELL ["/bin/bash", "-o", "pipefail", "-c"]
RUN set -ex \
    && chown www-data:www-data /var/www/html \
    && echo "APP_SECRET=$(tr -dc A-Za-z0-9 < /dev/urandom | head -c 32)" >> .env \
    && echo "APP_ENV=${ENVIRONMENT}" >> .env \
    && php bin/console cache:warmup --env=${ENVIRONMENT}

# Prod environment
FROM dev as prod

RUN rm -rf webpack.config.js package.json yarn.lock assets

EXPOSE 80
