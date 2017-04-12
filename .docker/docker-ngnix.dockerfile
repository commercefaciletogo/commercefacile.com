FROM nginx:latest

MAINTAINER thomasdolar@gmail.com

COPY ./.docker/conf/nginx.conf /etc/nginx/conf.d/default.conf

# install filebeat
ENV FILEBEAT_VERSION 5.1.1

RUN apt-get update -qq \
 && apt-get install -qqy curl \
 && apt-get clean

RUN curl -L -O https://artifacts.elastic.co/downloads/beats/filebeat/filebeat-${FILEBEAT_VERSION}-amd64.deb \
    && dpkg -i filebeat-${FILEBEAT_VERSION}-amd64.deb \
    && rm filebeat-${FILEBEAT_VERSION}-amd64.deb

RUN rm /var/log/nginx/access.log /var/log/nginx/error.log

ADD ./.docker/conf/filebeat.yml /etc/filebeat/filebeat.yml

# CA cert
RUN mkdir -p /etc/pki/tls/certs
ADD ./.docker/conf/logstash-beats.crt /etc/pki/tls/certs/logstash-beats.crt

ADD ./.docker/conf/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
CMD [ "/usr/local/bin/start.sh" ]