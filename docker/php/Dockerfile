FROM php:8.1-fpm-alpine
RUN apk --update --no-cache add git

# Install Postgre PDO
RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www
EXPOSE 9000
