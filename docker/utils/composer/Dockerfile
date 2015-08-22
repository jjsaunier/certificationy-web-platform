FROM php:5.6-cli

RUN apt-get update && \
  DEBIAN_FRONTEND=noninteractive apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng12-dev \
    libbz2-dev \
    php-pear \
    curl \
    git \
  && rm -r /var/lib/apt/lists/*

RUN docker-php-ext-install mcrypt zip bz2 mbstring
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && docker-php-ext-install gd
RUN docker-php-ext-install pdo_mysql

RUN echo "memory_limit=1024M" > /usr/local/etc/php/conf.d/memory-limit.ini
RUN echo "date.timezone=${PHP_TIMEZONE:-UTC}" > /usr/local/etc/php/conf.d/date_timezone.ini

RUN cd /bin && curl -sS https://getcomposer.org/installer | php
RUN mv /bin/composer.phar /bin/composer

VOLUME ["/app"]
WORKDIR /app

CMD ["-"]
ENTRYPOINT ["composer", "--ansi"]
