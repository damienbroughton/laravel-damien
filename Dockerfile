# Use the official PHP 8.5.x image
FROM php:8.5

# Update package lists and install basic utilities
# - openssl: security libraries
# - zip/unzip: needed by composer for package extraction
# - git: required for composer to pull repositories
RUN apt-get update -y && apt-get install -y \
    openssl \
    zip \
    unzip \
    git

# Install Composer globally
# Composer is the dependency manager used by Laravel and many PHP projects
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

# Install MySQL development libraries required to compile PHP MySQL extensions
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libmariadb-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP database extensions
# - pdo: PHP Data Objects base extension
# - pdo_mysql: MySQL driver for PDO
RUN docker-php-ext-install pdo pdo_mysql

# Optional check to confirm mbstring module is available
# Laravel requires mbstring
RUN php -m | grep mbstring

# Set working directory inside container
WORKDIR /app

# Copy application source code into the container
COPY . /app

# Install PHP dependencies defined in composer.json
RUN composer install

# Start Laravel development server
# Bind to 0.0.0.0 so it is accessible outside the container
CMD php artisan serve --host=0.0.0.0 --port=8000

# Expose port used by Laravel server
EXPOSE 8000