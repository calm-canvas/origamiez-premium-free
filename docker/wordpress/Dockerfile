FROM wordpress:6.9.0-php8.3-apache

# Giữ nguyên logic ARG và RUN để map UID/GID của bạn [cite: 1-9]
ARG WWWUSER=1000
ARG WWWGROUP=1000

RUN if [ ${WWWUSER} -ne 33 ]; then \
        EXISTING_USER=$(getent passwd ${WWWUSER} | cut -d: -f1); \
        if [ ! -z "$EXISTING_USER" ]; then userdel -f $EXISTING_USER; fi; \
        usermod -u ${WWWUSER} www-data; \
    fi && \
    if [ ${WWWGROUP} -ne 33 ]; then \
        EXISTING_GROUP=$(getent group ${WWWGROUP} | cut -d: -f1); \
        if [ ! -z "$EXISTING_GROUP" ]; then groupdel $EXISTING_GROUP; fi; \
        groupmod -g ${WWWGROUP} www-data; \
    fi

RUN apt-get update && apt-get install -y \
    curl nano git \
    $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && rm -rf /var/lib/apt/lists/*

# Copy Composer [cite: 1]
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cấu hình Xdebug mặc định cho môi trường Dev
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ENV COMPOSER_ALLOW_SUPERUSER=1

# Ensure permissions on the home directory of www-data
RUN chown -R www-data:www-data /var/www