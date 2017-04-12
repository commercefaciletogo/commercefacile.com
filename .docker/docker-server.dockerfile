FROM tomsowerby/docker-laravel-php-cli

MAINTAINER thomasdolar@gmail.com

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get update \
    && apt-get -y install git cron curl\
    libgmp10 \
    libgmp-dev \
    mysql-client \
    && apt-get -y autoremove && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get install -y supervisor && \
    mkdir -p /var/log/supervisor
COPY .docker/conf/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
VOLUME ["/var/log/supervisor"]

RUN /usr/bin/curl -sS https://getcomposer.org/installer |/usr/bin/php
RUN /bin/mv composer.phar /usr/local/bin/composer

# clean up our mess
RUN apt-get remove --purge -y software-properties-common && \
    apt-get autoremove -y && \
    apt-get clean && \
    apt-get autoclean && \
    echo -n > /var/lib/apt/extended_states && \
    rm -rf /var/lib/apt/lists/* && \
    rm -rf /usr/share/man/?? && \
    rm -rf /usr/share/man/??_*

VOLUME /var/www/commercefacile

WORKDIR /var/www/commercefacile

# add entry to crontab
RUN (crontab -l 2>/dev/null; echo "* * * * * php /var/www/commercefacile/artisan schedule:run >> /dev/null 2>&1")| crontab -

# expose ports
EXPOSE 8000

# set container entrypoints
ENTRYPOINT ["/bin/bash","-c"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

