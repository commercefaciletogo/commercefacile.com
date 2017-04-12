FROM nginx:latest

MAINTAINER thomasdolar@gmail.com

COPY ./.docker/conf/nginx.conf /etc/nginx/conf.d/default.conf

# ENTRYPOINT ["nginx"]
# CMD ["-g", "daemon off;"]