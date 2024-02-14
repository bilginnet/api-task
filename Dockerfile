ARG TARGET_ARCH

# For Apple Silikon CPU (arm64v8)
FROM arm64v8/php:8.2-fpm-alpine AS arm_target

# For Intel CPU (x86_64)
FROM php:8.2-fpm-alpine AS intel_target

FROM ${TARGET_ARCH} AS base

RUN apk update && apk upgrade

RUN apk add --no-cache sqlite-dev

RUN docker-php-ext-install pdo pdo_sqlite

WORKDIR /var/www/html

USER www-data:www-data

CMD ["php-fpm"]

EXPOSE 9000
