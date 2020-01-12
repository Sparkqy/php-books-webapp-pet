FROM php:7.3-apache-stretch

ARG DEBIAN_FRONTEND=noninteractive

# Update
RUN apt-get -y update --fix-missing && \
    apt-get upgrade -y && \
    apt-get --no-install-recommends install -y apt-utils && \
    rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y git;
RUN apt-get install zip unzip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    pecl install xdebug-2.7.2 && \
    docker-php-ext-enable xdebug;

#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN pecl install xdebug-2.7.2 && \
#    docker-php-ext-enable xdebug

# Other PHP7 Extensions
#RUN docker-php-ext-install pdo_mysql && \
#    docker-php-ext-install pdo_sqlite && \
#    docker-php-ext-install mysqli && \
#    docker-php-ext-install curl && \
#    docker-php-ext-install tokenizer && \
#    docker-php-ext-install json && \
#    docker-php-ext-install zip && \
#    docker-php-ext-install -j$(nproc) intl && \
#    docker-php-ext-install mbstring && \
#    docker-php-ext-install gettext

# Enable apache modules
RUN a2enmod rewrite headers

# Cleanup
RUN rm -rf /usr/src/*