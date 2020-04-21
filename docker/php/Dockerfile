ARG PHP_VERSION=""
ARG XDEBUG='false'
FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm-alpine
RUN apk update; \
    apk upgrade; \
    apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev imap-dev yarn libzip-dev libintl icu-dev redis imagemagick-dev;
RUN docker-php-ext-install mysqli
RUN docker-php-ext-configure imap --with-imap
RUN docker-php-ext-install pdo pdo_mysql imap zip intl
RUN docker-php-ext-configure zip
RUN apk update \
  && apk add --no-cache --virtual .build-php \
    $PHPIZE_DEPS \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
#  && pecl install apcu \
#  && docker-php-ext-enable apcu \
#  && pecl install apcu_bc \
  && pecl install redis \
  && docker-php-ext-enable redis \
  && docker-php-ext-enable imagick
RUN if [ "$(php --version | head -n 1 | cut -d " " -f 2 | cut -c 1,3)" -gt "73" ]; then docker-php-ext-configure gd --with-freetype --with-jpeg; else docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-png-dir=/usr/include/ --with-jpeg-dir=/usr/include/; fi && \
    [ "$XDEBUG" = "false" ] || pecl install xdebug && docker-php-ext-enable xdebug && [ "$XDEBUG" = "false" ] || echo -en "\nxdebug.remote_enable=on\nxdebug.remote_autostart=0\nxdebug.remote_connect_back=off\nxdebug.remote_handler=dbgp\nxdebug.profiler_append=1\nxdebug.profiler_enable=0\nxdebug.profiler_enable_trigger=1\nxdebug.profiler_output_dir=$APP_DIR\nxdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
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
