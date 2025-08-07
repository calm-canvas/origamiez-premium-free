FROM wordpress:php8.4-fpm

LABEL maintainer="tranthethang@gmail.com"

# Create non-root user for security with specific UID/GID
ARG USER_ID=1000
ARG GROUP_ID=1000
ENV USER_ID=${USER_ID} \
    GROUP_ID=${GROUP_ID}
RUN groupadd -g $GROUP_ID owp && useradd -r -u $USER_ID -g owp owp

# Install wp-cli
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp \
    && wp --info --allow-root

# Download WordPress core
RUN php -d memory_limit=512M /usr/local/bin/wp core download --allow-root --path=/var/www/html

# Install necessary tools for wp-cli
RUN apt-get update && apt-get install -y \
    less \
    && rm -rf /var/lib/apt/lists/*

# Install Nginx and Supervisor
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

# Install mysql-client
RUN apt-get update && apt-get install -y default-mysql-client nano && rm -rf /var/lib/apt/lists/*

# Configure Nginx
COPY nginx.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Configure PHP-FPM
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

# Configure Supervisor to manage PHP-FPM and Nginx
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Create necessary directories and set proper ownership and permissions
RUN mkdir -p /var/log/supervisor \
    && mkdir -p /var/lib/nginx/body /var/lib/nginx/fastcgi /var/lib/nginx/proxy /var/lib/nginx/scgi /var/lib/nginx/uwsgi \
    && touch /var/log/php-fpm-slow.log \
    && chown -R owp:owp /var/www/html \
    && chown -R owp:owp /var/lib/nginx \
    && chown -R owp:owp /var/log/nginx \
    && chown owp:owp /var/log/php-fpm-slow.log \
    && chmod -R 755 /var/log/supervisor \
    && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80

# Start Supervisor (runs as root to manage processes, but processes run as owp user)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]