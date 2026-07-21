FROM php:8.3-fpm-alpine

WORKDIR /var/www

# Instala dependências do sistema e extensões do PHP para o PostgreSQL
RUN apk add --no-cache \
    postgresql-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo pdo_pgsql pgsql zip bcmath

# Instala o Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN chown -R www-data:www-data /var/www

EXPOSE 9000
CMD ["php-fpm"]