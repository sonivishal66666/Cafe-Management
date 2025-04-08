# Use PHP 8.2 image instead of 8.1
FROM php:8.2-apache

# Copy your PHP website into the container
COPY . /var/www/html/

# Use custom PHP config
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# Install necessary PHP extensions including mysqli
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli

# Set Apache to listen on port 8080
RUN echo "Listen 8080" >> /etc/apache2/ports.conf
RUN sed -i 's/80/8080/' /etc/apache2/sites-available/000-default.conf

# Expose the port that your app will run on
EXPOSE 8080

# Start Apache in the foreground
CMD ["apache2-foreground"]
