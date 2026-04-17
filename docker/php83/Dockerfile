FROM php:8.3-fpm

ENV DEBIAN_FRONTEND=noninteractive
ENV ACCEPT_EULA=Y
ENV OPENSSL_CONF=/etc/ssl/openssl-legacy.cnf

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    gnupg \
    ca-certificates \
    unixodbc \
    unixodbc-dev \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libicu-dev \
    libxml2-dev \
    libonig-dev \
    && curl https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /usr/share/keyrings/microsoft.gpg \
    && echo "deb [arch=amd64 signed-by=/usr/share/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql17 \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        mysqli \
        pdo \
        pdo_mysql \
        pgsql \
        pdo_pgsql \
        intl \
        mbstring \
        zip \
        gd \
        soap \
        xml \
    && pecl install sqlsrv-5.12.0 pdo_sqlsrv-5.12.0 \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY docker/php83/openssl-legacy.cnf /etc/ssl/openssl-legacy.cnf
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
