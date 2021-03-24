# Common
FROM docker.io/nginx/unit:1.22.0-php8.0 as common

RUN set -xe \
    && apt-get -y update \
    && apt-get -y install --no-install-recommends apt-utils zip unzip

COPY .unit.conf.json /docker-entrypoint.d/.unit.conf.json

# Development environment
FROM common as dev
WORKDIR /var/www/html

COPY .env.example /var/www/html/.env
RUN sed -i "s/ThisTokenIsNotSecretChangeIt/$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)/g" .env

COPY --from=composer:2.0.11 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock /var/www/html/
RUN composer install \
    --ignore-platform-reqs \
    --no-ansi \
    --no-autoloader \
    --no-interaction \
    --no-scripts

COPY . .

RUN set -ex \
    && composer dump-autoload --optimize --classmap-authoritative \
    && composer check-platform-reqs \
    && php bin/console cache:warmup

# Prod environment
FROM common as prod
WORKDIR /var/www/html

RUN echo "APP_SECRET=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)" >> .env

COPY --from=composer:2.0.11 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock /var/www/html/
RUN composer install \
    --ignore-platform-reqs \
    --no-ansi \
    --no-dev \
    --no-autoloader \
    --no-interaction \
    --no-scripts

COPY ./bin/console /var/www/html/bin/console
COPY ./config/ /var/www/html/config/
COPY ./public/ /var/www/html/public/
COPY ./src/ /var/www/html/src/
COPY ./.rr.yaml /var/www/html/.rr.yaml

RUN set -ex \
    && composer dump-autoload --optimize --classmap-authoritative \
    && composer check-platform-reqs \
    && php bin/console cache:warmup

RUN rm composer.json composer.lock

EXPOSE 80
