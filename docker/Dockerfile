FROM richarvey/nginx-php-fpm:1.3.10

ENV REMOVE_FILES=0
ENV SKIP_COMPOSER=1
ENV SKIP_CHOWN=1

ENV ERRORS=1
ENV PHP_ERRORS_STDERR=1

ENV ENABLE_XDEBUG=1
ENV XDEBUG_CONFIG="remote_host=host-container"

RUN apk add --update autoconf g++ libtool make pcre-dev postgresql-dev

RUN docker-php-ext-configure bcmath \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install xml \
    && docker-php-ext-install pgsql \
    && docker-php-ext-install pdo_pgsql

RUN apk add imagemagick-dev \
    && pecl install imagick \
    && docker-php-ext-enable imagick

RUN apk del autoconf g++ libtool make pcre-dev postgresql-dev

ADD script/dev-start.sh /dev-start.sh

CMD ["/dev-start.sh"]
