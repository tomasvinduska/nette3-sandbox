ARG PHP_VERSION=""
FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm-alpine
RUN apk update; \
    apk upgrade; \
    apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev;
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-configure gd \
    --with-gd \
    --with-freetype-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ && \
  NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
  docker-php-ext-install -j${NPROC} gd && \
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
          php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
          php -r "unlink('composer-setup.php');" && \
          chmod +x /usr/local/bin/composer && \
          composer self-update \
          && composer global require hirak/prestissimo
COPY php.ini /usr/local/etc/php/php.ini
WORKDIR /var/www/web/
