# Common
FROM php:7.4.12-cli-alpine as common

# Install packages and extensions
RUN set -ex \
    && apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS yaml-dev curl-dev \
    && pecl install redis apcu yaml \
    && docker-php-ext-enable redis opcache apcu yaml \
    && docker-php-ext-install sockets curl \
    && rm -rf /tmp/pear \
    && cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini \
    && sed -i "s/memory_limit =.*/memory_limit = 256M/g" /usr/local/etc/php/php.ini \
    && sed -i "s/display_errors =.*/display_errors = stderr/g" /usr/local/etc/php/php.ini \
    && echo "opcache.enable_cli=1" >> /usr/local/etc/php/php.ini \
    && echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/php.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/php.ini \
    && echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/php.ini \
    && echo "apc.enable_cli=1" >> /usr/local/etc/php/php.ini \
    && apk del --purge .build-dependencies \
    && apk add --no-cache yaml

# Development environment
FROM common as dev
WORKDIR /var/www/html

RUN set -ex \
    && apk add --update --no-cache --virtual .build-dependencies openssl \
    && apk del --purge .build-dependencies

RUN set -ex \
    && mkdir -p /etc/roadrunner/ssl/private \
    && chmod 755 /etc/roadrunner/ssl \
    && chmod 710 /etc/roadrunner/ssl \
    && chown -R root:root /etc/roadrunner

RUN openssl req -x509 -sha256 -nodes -days 365 -newkey rsa:4096 -keyout /etc/roadrunner/ssl/private/server.key -out /etc/roadrunner/ssl/server.crt -subj "/CN=localhost/O=makeit.lv/C=LV"

RUN set -ex \
    && chmod 644 /etc/roadrunner/ssl/server.crt \
    && chmod 640 /etc/roadrunner/ssl/private/server.key

COPY .env.example /var/www/html/.env
RUN sed -i "s/ThisTokenIsNotSecretChangeIt/$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)/g" .env

COPY --from=composer:2.0.7 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock /var/www/html/
RUN composer install \
    --ignore-platform-reqs \
    --no-ansi \
    --no-autoloader \
    --no-interaction \
    --no-scripts

COPY . .

RUN set -ex \
    && chown -R www-data: /var/www/html \
    && composer dump-autoload --optimize --classmap-authoritative \
    && composer check-platform-reqs \
    && php bin/console cache:warmup \
    && ./vendor/bin/rr get-binary --location /usr/local/bin

EXPOSE 1070
CMD ["rr", "serve", "-v", "-d", "-c", ".rr.dev.yaml"]
