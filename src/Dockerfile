FROM php:7.4-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    gnupg \
    unixodbc \
    unixodbc-dev \
    apt-transport-https \
    ca-certificates \
    curl \
    build-essential \
    autoconf \
    libc-dev \
    pkg-config

# Tambah repo Microsoft (Debian 11)
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/11/prod.list \
    > /etc/apt/sources.list.d/mssql-release.list

# 🔥 INSTALL ODBC DRIVER 17 (WAJIB)
RUN apt-get update && ACCEPT_EULA=Y apt-get install -y \
    msodbcsql17

# 🔥 FIX TLS / SSL (INI KUNCI UTAMA KASUS KAMU)
RUN sed -i 's/MinProtocol = TLSv1.2/MinProtocol = TLSv1/' /etc/ssl/openssl.cnf \
    && sed -i 's/CipherString = DEFAULT@SECLEVEL=2/CipherString = DEFAULT@SECLEVEL=1/' /etc/ssl/openssl.cnf

# Install SQLSRV extension
RUN pecl channel-update pecl.php.net \
    && printf "\n" | pecl install sqlsrv-5.10.1 \
    && printf "\n" | pecl install pdo_sqlsrv-5.10.1 \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

# Extension tambahan CI3
RUN docker-php-ext-install mysqli

# Enable Apache rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html