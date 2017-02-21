FROM php:7.0-apache
EXPOSE 80 443
COPY src/ /var/www/html
