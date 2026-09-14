# Build the Vite production assets separately so Node.js is not part of the
# final PHP image.
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build


# Install only Composer production dependencies.
FROM composer:2 AS dependencies

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts


FROM php:8.3-cli-alpine

WORKDIR /var/www/html

# pdo_mysql is required for the production MySQL database.
RUN apk add --no-cache icu-libs libzip oniguruma \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS icu-dev libzip-dev oniguruma-dev \
    && docker-php-ext-install -j"$(nproc)" bcmath intl mbstring opcache pdo_mysql zip \
    && apk del .build-deps

COPY . .
COPY --from=dependencies /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

RUN mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && php artisan storage:link \
    && chown -R www-data:www-data storage bootstrap/cache

USER www-data

EXPOSE 10000

# Render supplies PORT. Migrations are safe to run on every deploy; do not add
# --seed here because this project's seed data contains demo credentials.
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
