FROM ubuntu:14.04

RUN apt-get update && apt-get install -y nginx

ADD nginx.conf /etc/nginx/
ADD notification.conf /etc/nginx/sites-available/
ADD ssl /etc/nginx/ssl

RUN ln -s /etc/nginx/sites-available/certificationy.conf /etc/nginx/sites-enabled/certificationy
RUN rm /etc/nginx/sites-enabled/default
RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

CMD ["nginx"]

EXPOSE 80
