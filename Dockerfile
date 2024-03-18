FROM php:7.4-apache
WORKDIR /var/www/html
COPY . /var/www/html

ENV APACHE_DOCUMENT_ROOT /public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/* \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader

RUN apt-get update && apt-get install -y apache2

RUN a2enmod rewrite

RUN docker-php-ext-install pdo pdo_mysql

# COPY apache2 /etc/apache2/

CMD ["apache2-foreground"]


