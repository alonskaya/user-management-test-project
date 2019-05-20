FROM php:7.2-fpm-alpine

ARG WITH_XDEBUG=false

RUN apk add --update --no-cache \
        postgresql-dev \
        bash \
    #install php extensions
    && docker-php-ext-install \
        pdo_pgsql \
        pgsql \
        bcmath \
        opcache \
    #clear artifacts
    && apk del \
        postgresql-libs \
       	libsasl \
       	db

RUN if [ "${WITH_XDEBUG}" = "true" ] ; then \
        apk add --update --no-cache $PHPIZE_DEPS; \
        pecl install xdebug; \
        docker-php-ext-enable xdebug; \
        echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_enable = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_autostart = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_handler = dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_port = 9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_mode = req" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
fi ;

RUN chown -R www-data:www-data /var/www
COPY --chown=www-data:www-data . /var/www/

USER www-data
WORKDIR /var/www