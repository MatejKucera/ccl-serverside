FROM php:7.4.27-apache-buster AS web

WORKDIR /app

RUN apt-get update -yqq --allow-releaseinfo-change

RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY docker/web/entrypoint.sh /entrypoint.sh
ENTRYPOINT [ "sh", "/entrypoint.sh" ]

COPY docker/web/default.conf /etc/apache2/sites-enabled/000-default.conf
COPY . /app