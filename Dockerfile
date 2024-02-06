FROM php:8.1-fpm

# Arguments defined in docker-compose.yml
ARG app_env


USER root
# Install dependencies
RUN apt-get update && apt-get install -y git curl zip libpq-dev cron sshpass \
    && apt-get clean  \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions exif
RUN install-php-extensions bcmath
RUN install-php-extensions ctype
RUN install-php-extensions fileinfo
RUN install-php-extensions json
RUN install-php-extensions mbstring
RUN install-php-extensions openssl
RUN install-php-extensions PDO
RUN install-php-extensions tokenizer
RUN install-php-extensions pdo_mysql
RUN install-php-extensions opcache
RUN install-php-extensions redis
RUN install-php-extensions imagick
RUN install-php-extensions gd
RUN install-php-extensions zip
RUN install-php-extensions @composer

# Set working directory
WORKDIR /var/www/

# Copy existing application directory permissions
COPY . .

# Add user for laravel application

RUN if [ $(getent group www) ]; then  echo 'Group Exists' ;else groupadd -g 1000 www;fi;
RUN if [ $(getent passwd www) ];then echo 'Group Exists';else useradd -u 1000 -ms /bin/bash -g www www;fi;

# Copy existing application directory contents

COPY /app /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www
RUN chmod 777 storage -R

RUN php artisan storage:link
# Change current user to www


COPY ./entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint
ENTRYPOINT ["entrypoint"]

USER www
# Expose port 9000 and start php-fpm server
CMD ["php-fpm"]
