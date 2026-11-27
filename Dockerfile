FROM wordpress:latest

COPY wp-content /var/www/html/wp-content
COPY uploads.ini /usr/local/etc/php/conf.d/uploads.ini

