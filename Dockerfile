# Build
FROM composer:2.0.11 as build

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

# Common
FROM docker.io/nginx/unit:1.22.0-php8.0 as common

ARG ENVIRONMENT

WORKDIR /var/www/html

COPY .unit.conf.json /docker-entrypoint.d/.unit.conf.json
COPY --from=build /app/vendor/ vendor
COPY . .

SHELL ["/bin/bash", "-o", "pipefail", "-c"]
RUN set -ex \
    && echo "APP_SECRET=$(tr -dc A-Za-z0-9 < /dev/urandom | head -c 32)" >> .env \
    && echo "APP_ENV=${ENVIRONMENT}" >> .env \
    && php bin/console cache:warmup --env=${ENVIRONMENT}

# Prod environment
FROM common as prod
EXPOSE 80
