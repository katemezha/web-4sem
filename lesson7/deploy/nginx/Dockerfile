FROM nginx:alpine

ENV DATA_ROOT /data

RUN set -x ; \
  addgroup -g 82 -S www-data ; \
  adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

RUN mkdir -p ${DATA_ROOT}/public

RUN mkdir -p ${DATA_ROOT}/nginx/cache && chown nginx:nginx ${DATA_ROOT}/nginx/cache

COPY deploy/nginx/config/nginx.conf /etc/nginx/nginx.conf
