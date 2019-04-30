# Use phusion/baseimage as base image. To make your builds reproducible, make
# sure you lock down to a specific version, not to `latest`!
# See https://github.com/phusion/baseimage-docker/blob/master/Changelog.md for
# a list of version numbers.
FROM phusion/baseimage

# Use baseimage-docker's init system.
CMD ["/sbin/my_init"]

RUN mkdir -p /etc/my_init.d

#####################################
# Kaspersky endpoint protection:
#####################################
RUN apt-get update && apt-get install -y wget perl make gcc
ARG KES_SOURCE
RUN mkdir /root/kes
RUN wget ${KES_SOURCE} -O /root/kes/kes.deb
RUN dpkg -i /root/kes/kes.deb
COPY ./system/kes/autoinstall /root/kes/autoinstall
RUN /opt/kaspersky/kesl/bin/kesl-setup.pl --autoinstall=/root/kes/autoinstall; exit 0
COPY ./system/kes/start.sh /etc/my_init.d/kes.sh
RUN chmod +x /etc/my_init.d/kes.sh

#####################################
# Nginx:
#####################################
RUN apt-get install -y nginx
RUN echo "daemon off;" >> /etc/nginx/nginx.conf
RUN mkdir /etc/service/nginx
COPY ./system/nginx/service.sh /etc/service/nginx/run
RUN chmod +x /etc/service/nginx/run
COPY /etc/nginx/sites-available /etc/nginx/sites-available.original
COPY ./etc/nginx/sites-available/default /etc/nginx/sites-available/default
COPY /etc/nginx/nginx.conf /etc/nginx/nginx.conf.original
COPY ./etc/nginx/nginx.conf /etc/nginx/nginx.conf

#####################################
# PHP-FPM 7.2:
#####################################
RUN add-apt-repository -y ppa:ondrej/php && apt-get update && apt-get install -y php7.2-fpm
RUN mkdir /run/php && chown www-data:www-data -R /run/php
RUN mkdir /etc/service/php-fpm
COPY ./system/php-fpm/service.sh /etc/service/php-fpm/run
RUN chmod +x /etc/service/php-fpm/run
COPY /etc/php/7.2/cli/php.ini /etc/php/7.2/cli/php.ini.original
COPY ./etc/php/7.2/cli/php.ini /etc/php/7.2/cli/php.ini
COPY /etc/php/7.2/fpm/php.ini /etc/php/7.2/fpm/php.ini.original
COPY ./etc/php/7.2/fpm/php.ini /etc/php/7.2/fpm/php.ini
COPY /etc/php/7.2/fpm/pool.d/www.conf /etc/php/7.2/fpm/pool.d/www.conf.original
COPY ./etc/php/7.2/fpm/pool.d/www.conf /etc/php/7.2/fpm/pool.d/www.conf

RUN apt-get install -y unzip curl git

#####################################
# Composer:
#####################################
RUN curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/html/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer

# Allow Composer to be run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

#####################################
# Web interface:
#####################################
RUN rm -rf /var/www/html/*
COPY ./www /var/www/html
WORKDIR /var/www/html
RUN composer install --no-dev

#####################################
#  Clean up APT:
#####################################
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*