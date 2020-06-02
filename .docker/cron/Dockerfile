FROM php:5.6

ARG UID=1000

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    cron \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libxml2-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    zlib1g-dev libicu-dev g++ \
    nano && \

    docker-php-ext-install mcrypt && \
    docker-php-ext-install pdo_pgsql && \
    docker-php-ext-install soap && \
    docker-php-ext-install gd && \
    docker-php-ext-configure gd \
        --enable-gd-native-ttf \
        --with-jpeg-dir=/usr/lib \
        --with-freetype-dir=/usr/include/freetype2 && \
    docker-php-ext-install gd && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl && \

    rm -r /var/lib/apt/lists/* && \

#    mkfifo --mode 0666 /var/log/cron.log && \
    touch /var/log/cron.log && \
    chmod 666 /var/log/cron.log && \

    usermod -u ${UID} www-data

COPY root /etc/cron.d
COPY start-cron /usr/sbin
COPY ./php.ini    /usr/local/etc/php/php.ini

CMD ["start-cron"]
