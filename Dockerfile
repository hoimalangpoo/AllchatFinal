FROM php:7.4-apache
WORKDIR /var/www/html
COPY . /var/www/html

RUN a2enmod ssl
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
# Set environment variables for SSL certificate and key paths
# ENV APACHE_SSL_CERTIFICATE /var/www/html/chathelper_cert.pem
# ENV APACHE_SSL_KEY /var/www/html/chathelper_key.pem

# # Replace SSL certificate and key paths in default-ssl.conf
# RUN sed -i 's#/etc/ssl/certs/ssl-cert-snakeoil.pem#${APACHE_SSL_CERTIFICATE}#g' /etc/apache2/sites-available/default-ssl.conf
# RUN sed -i 's#/etc/ssl/private/ssl-cert-snakeoil.key#${APACHE_SSL_KEY}#g' /etc/apache2/sites-available/default-ssl.conf


# RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf 

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/* \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader

RUN apt-get update && apt-get install -y apache2

RUN a2enmod rewrite

RUN docker-php-ext-install pdo pdo_mysql

EXPOSE 80
EXPOSE 443

CMD ["apache2-foreground"]

