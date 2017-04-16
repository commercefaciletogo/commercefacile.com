FROM        nginx:latest

MAINTAINER  thomasdolar@gmail.com

COPY        ./.docker/conf/nginx.conf /etc/nginx/conf.d/default.conf

RUN         echo 'deb http://ftp.debian.org/debian jessie-backports main' | tee /etc/apt/sources.list.d/backports.list && \
            apt-get update && \
            apt-get install certbot letsencrypt -y -t jessie-backports

RUN         mkdir -p /var/www/public/letsencrypt/.well-known/acme-challenge

RUN         certbot --quiet certonly --webroot -w /var/www/public  \
            -d www.commercefacile.com -d commercefacile.com \
            --email commercefaciletogo@gmail.com --agree-tos