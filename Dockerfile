FROM wordpress:php8.3-fpm

LABEL maintainer="tranthethang@gmail.com"

# Create non-root user for security with specific UID/GID
ARG USER_ID=1000
ARG GROUP_ID=1000
ENV USER_ID=${USER_ID} \
    GROUP_ID=${GROUP_ID}

# Install all dependencies in a single RUN to minimize layers
RUN groupadd -g $GROUP_ID owp && useradd -r -u $USER_ID -g owp owp && \
    apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    supervisor \
    default-mysql-client \
    curl \
    && rm -rf /var/lib/apt/lists/* && \
    curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp && \
    wp --info --allow-root && \
    php -d memory_limit=512M /usr/local/bin/wp core download --allow-root --path=/var/www/html

# Copy configuration files
COPY nginx.conf /etc/nginx/sites-available/default
COPY www.conf /usr/local/etc/php-fpm.d/www.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker-entrypoint.sh /docker-entrypoint.sh

# Create necessary directories and set proper ownership and permissions
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default && \
    mkdir -p /var/log/supervisor && \
    mkdir -p /var/lib/nginx/body /var/lib/nginx/fastcgi /var/lib/nginx/proxy /var/lib/nginx/scgi /var/lib/nginx/uwsgi && \
    touch /var/log/php-fpm-slow.log && \
    chown -R owp:owp /var/www/html && \
    chown -R owp:owp /var/lib/nginx && \
    chown -R owp:owp /var/log/nginx && \
    chown owp:owp /var/log/php-fpm-slow.log && \
    chmod 750 /var/log/supervisor && \
    chmod 750 /var/www/html && \
    chmod +x /docker-entrypoint.sh

# Health check
HEALTHCHECK --interval=30s --timeout=5s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/wp-admin/ping.php || exit 1

# Expose port 80
EXPOSE 80

# Start with entrypoint for graceful shutdown
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]