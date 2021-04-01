# Build php and nginx unit
FROM alpine:edge as build

ENV UNIT_VERSION 1.22.0
ENV COMMON_PACKAGES \
    php8=8.0.3-r0 \
    php8-dev=8.0.3-r0 \
    php8-embed=8.0.3-r0 \
    php8-bcmath=8.0.3-r0 \
    php8-dom=8.0.3-r0 \
    php8-ctype=8.0.3-r0 \
    php8-curl=8.0.3-r0 \
    php8-fileinfo=8.0.3-r0 \
    php8-gd=8.0.3-r0 \
    php8-iconv=8.0.3-r0 \
    php8-intl=8.0.3-r0 \
    php8-mbstring=8.0.3-r0 \
    php8-mysqlnd=8.0.3-r0 \
    php8-opcache=8.0.3-r0 \
    php8-openssl=8.0.3-r0 \
    php8-posix=8.0.3-r0 \
    php8-session=8.0.3-r0 \
    php8-simplexml=8.0.3-r0 \
    php8-soap=8.0.3-r0 \
    php8-xml=8.0.3-r0 \
    php8-zip=8.0.3-r0 \
    php8-tokenizer=8.0.3-r0 \
    curl=7.76.0-r0 \
    gcc=10.2.1_git20210328-r0 \
    musl-dev=1.2.2-r2 \
    make=4.3-r0

WORKDIR /tmp/unit-${UNIT_VERSION}

COPY docker-entrypoint.sh /usr/local/bin/

SHELL ["/bin/ash", "-eo", "pipefail", "-c"]
RUN set -xe \
    && apk update \
    && apk add --no-cache --update ${COMMON_PACKAGES} \
    && ln /usr/bin/php8 /usr/bin/php \
    && chmod +x /usr/local/bin/docker-entrypoint.sh \
    && wget -P /tmp -qO- "http://unit.nginx.org/download/unit-${UNIT_VERSION}.tar.gz" | tar xvz -C /tmp \
    && ./configure --prefix=/usr --modules=/usr/lib/unit/modules --control="unix:/var/run/control.unit.sock" --log=/dev/stdout --pid=/var/run/unit.pid \
    && ./configure php --module=php --config=/usr/bin/php-config8 --lib-path=/usr/lib/php8 \
    && make install \
    && rm -rf /var/cache/apk/* /tmp/* /var/tmp/* \
    && addgroup -g 82 -S www-data \
    && adduser -u 82 -D -S -G www-data www-data

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["unitd", "--no-daemon", "--control", "unix:/var/run/control.unit.sock"]

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

# Dev environment
FROM build as dev

ARG ENVIRONMENT

WORKDIR /var/www/html

COPY unit.conf.json /docker-entrypoint.d/unit.conf.json
COPY --from=vendor /app/vendor/ vendor
COPY . .

SHELL ["/bin/ash", "-eo", "pipefail", "-c"]
RUN set -ex \
    && chown www-data:www-data /var/www/html \
    && echo "APP_SECRET=$(tr -dc A-Za-z0-9 < /dev/urandom | head -c 32)" >> .env \
    && echo "APP_ENV=${ENVIRONMENT}" >> .env \
    && php bin/console cache:warmup --env=${ENVIRONMENT}

# Prod environment
FROM dev as prod
EXPOSE 80
