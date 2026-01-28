FROM wordpress:6.9.0-fpm-alpine

# Cài đặt các extension cần thiết cho WordPress & Cache
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    icu-dev \
    libxml2-dev \
    oniguruma-dev \
    shadow \
    $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        mysqli \
        pdo_mysql \
        zip \
        opcache \
        intl \
        bcmath \
        exif \
        soap \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del $PHPIZE_DEPS

# Cấu hình OPcache và PHP tối ưu cho Production
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=10000'; \
    echo 'opcache.revalidate_freq=60'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.enable_cli=1'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini \
    && { \
    echo 'upload_max_filesize=64M'; \
    echo 'post_max_size=64M'; \
    echo 'memory_limit=256M'; \
    echo 'max_execution_time=300'; \
    echo 'date.timezone=UTC'; \
    echo 'display_errors=Off'; \
    echo 'log_errors=On'; \
    } > /usr/local/etc/php/conf.d/wp-production.ini

ARG WWWUSER=1000
ARG WWWGROUP=1000

RUN usermod -u ${WWWUSER} www-data && \
    groupmod -g ${WWWGROUP} www-data && \
    apk del shadow

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html
