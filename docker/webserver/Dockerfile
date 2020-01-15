FROM php:7.4-apache

# Install necessary options
RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && apt-get update && apt-get install -y git \
    curl \
    nano \
    zip \
    unzip \
    && pecl channel-update pecl.php.net \
    && pecl install xdebug-2.8.0 \
    && docker-php-ext-enable xdebug

# Install RewriteMod for .htaccess file
RUN a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install the working directory for the project
WORKDIR /var/www/html/php-books-db