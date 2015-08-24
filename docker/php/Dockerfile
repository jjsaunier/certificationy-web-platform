FROM ubuntu:14.04

MAINTAINER Johann Saunier <johann_27@hotmail.fr>

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y php5-common php5-cli php5-fpm php5-mcrypt php5-mysql php5-apcu php5-gd php5-imagick php5-curl php5-intl php5-redis php5-imap php5-json
RUN apt-get install -y supervisor

RUN sudo service php5-fpm stop
RUN sudo service supervisor stop

RUN mkdir -p /var/log/php/
RUN touch /var/log/php/php5-fpm.log

ADD php-fpm.ini /etc/php5/fpm/php.ini
ADD php-cli.ini /etc/php5/cli/php.ini
ADD certificationy.pool.conf /etc/php5/fpm/pool.d/certificationy.conf
ADD php-fpm.conf /etc/php5/fpm/php-fpm.conf

ADD supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
ADD supervisord/php.conf /etc/supervisor/conf.d/php.conf

RUN usermod -u 1000 www-data

RUN supervisorctl start php-fpm

CMD ["/usr/bin/supervisord"]

EXPOSE 9000 9001
