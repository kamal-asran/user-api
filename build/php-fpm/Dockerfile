FROM php:8.1.4-fpm-buster

RUN apt-get update && apt-get install -y libmemcached-dev zlib1g-dev libssl-dev wget && \
    apt-get install -y curl libxml2-dev vim libzip-dev git zip unzip jpegoptim optipng && \
    apt-get install -y pngquant gifsicle libpng-dev libjpeg62-turbo-dev libfreetype6-dev libonig-dev libpq-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install gd mbstring bcmath pdo pdo_mysql

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

WORKDIR /usr/local/etc/php/conf.d/

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-install exif




RUN apt-get update && apt-get install -y gnupg \
  && curl -sL https://deb.nodesource.com/setup_16.x | bash - \
  && apt-get install -y nodejs


RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN apt-get install -y cron

ADD .crontab /etc/cron.d/cron
RUN chmod 0644 /etc/cron.d/cron
RUN touch /var/log/cron.log

WORKDIR /var/www/html/user_api_backend



# Set up permissions
RUN chown -R www-data:www-data /var/www/html/user_api_backend
RUN chmod -R g+w /var/www/html/user_api_backend

# RUN chown -R www-data:www-data /var/www/html/user_api_backend/storage
# RUN chmod -R 755 /var/www/html/user_api_backend/storage

# Install project dependencies
# RUN composer install --no-interaction --optimize-autoloader

CMD cron && docker-php-entrypoint php-fpm