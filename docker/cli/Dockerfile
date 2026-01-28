FROM wordpress:cli-php8.3

ARG WWWUSER=1000
ARG WWWGROUP=1000

USER root

# Alpine uses 'shadow' package for usermod/groupmod, or we can use 'sed'/'apk'
RUN apk add --no-cache shadow && \
    if [ ${WWWUSER} -ne 82 ]; then \
        EXISTING_USER=$(getent passwd ${WWWUSER} | cut -d: -f1); \
        if [ ! -z "$EXISTING_USER" ]; then userdel -f $EXISTING_USER; fi; \
        usermod -u ${WWWUSER} www-data; \
    fi && \
    if [ ${WWWGROUP} -ne 82 ]; then \
        EXISTING_GROUP=$(getent group ${WWWGROUP} | cut -d: -f1); \
        if [ ! -z "$EXISTING_GROUP" ]; then groupdel $EXISTING_GROUP; fi; \
        groupmod -g ${WWWGROUP} www-data; \
    fi && \
    apk del shadow

USER www-data
