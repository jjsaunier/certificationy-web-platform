FROM ubuntu:14.04

MAINTAINER Johann Saunier <johann_27@hotmail.fr>

ENV DEBIAN_FRONTEND noninteractive

RUN apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 0xcbcb082a1bb943db
RUN echo "deb http://mariadb.mirror.iweb.com/repo/10.0/ubuntu `lsb_release -cs` main" > /etc/apt/sources.list.d/mariadb.list
RUN apt-get update
RUN apt-get install -y mariadb-server
RUN rm -rf /var/lib/apt/lists/*
RUN sed -i 's/^\(bind-address\s.*\)/# \1/' /etc/mysql/my.cnf
RUN echo "mysqld_safe &" > /tmp/config
RUN echo "mysqladmin --silent --wait=30 ping || exit 1" >> /tmp/config
RUN echo "mysql -e 'GRANT ALL PRIVILEGES ON *.* TO \"root\"@\"%\" WITH GRANT OPTION;'" >> /tmp/config
RUN bash /tmp/config
RUN rm -f /tmp/config

VOLUME ["/etc/mysql", "/var/lib/mysql"]

WORKDIR /data

CMD ["mysqld_safe"]

EXPOSE 3306
