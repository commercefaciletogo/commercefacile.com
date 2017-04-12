FROM                    node:latest

MAINTAINER              thomasdolar@gmail.com

ENV                     APP_ENV=production

RUN                     npm install -g laravel-echo-server

#VOLUME                  /var/www/socket

#WORKDIR                 /var/www/socket

ENTRYPOINT              ["laravel-echo-server", "start"]