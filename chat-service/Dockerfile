FROM php:8.1-apache

# Copy service files
COPY . /var/www/html/

# Ensure permissions and enable rewrite
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

WORKDIR /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
