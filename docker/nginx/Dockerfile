FROM nginx:1.14

COPY ./docker/nginx/certs /etc/nginx/certs
COPY ./docker/nginx/nginx.conf ./docker/nginx/server.conf /etc/nginx/

COPY ./public/ /var/www/html/public/
