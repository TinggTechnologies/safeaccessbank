# Use an official PHP runtime as a parent image
FROM php:7.4-apache

# Install necessary dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libopencv-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install opencv

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80
