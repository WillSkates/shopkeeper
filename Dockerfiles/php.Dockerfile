#!/bin/bash

FROM scratch

ADD alpine.tar.gz /

RUN echo "https://uk.alpinelinux.org/alpine/v3.20/main" > /etc/apk/repositories
RUN echo "https://uk.alpinelinux.org/alpine/v3.20/community" >> /etc/apk/repositories

RUN apk add bash \
            php83 \
            php83-ctype \
            php83-dom \
            php83-fileinfo \
            php83-opcache \
            php83-pdo_sqlite \
            php83-session \
            php83-simplexml \
            php83-tokenizer \
            php83-xml \
            php83-xmlwriter \
            php83-xdebug \
            composer

RUN echo "zend_extension=xdebug.so" > /etc/php83/conf.d/99-xdebug.ini \
    && echo "xdebug.mode=coverage" >> /etc/php83/conf.d/99-xdebug.ini


COPY entrypoint.sh /entrypoint.sh

RUN php -v \
    && php -m \ 
    && composer --version \
    && mkdir /work \
    && chmod +x /entrypoint.sh


ENTRYPOINT ["/entrypoint.sh"]
WORKDIR "/work"
