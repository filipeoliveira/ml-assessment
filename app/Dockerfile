FROM php:8.2-apache
# Prevent warning message for FQDN (fully qualified domain name)
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    iputils-ping


# Clear out the local repository of retrieved package files
RUN apt-get clean

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo_mysql

# Install PHP Redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Configure Xdebug
RUN echo 'xdebug.mode=coverage' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.client_host=host.docker.internal' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.client_port=9003' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application files
COPY . /var/www/html/

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Update the default apache site with the config we created
ADD config/000-default.conf /etc/apache2/sites-enabled/000-default.conf

# Install dependencies
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install --no-scripts --no-autoloader

# Expose port 80 for Apache
EXPOSE 80