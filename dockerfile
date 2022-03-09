FROM	debian:9

RUN	apt-get -y update && apt-get -y upgrade && apt-get -y dist-upgrade
RUN	apt-get -y install libmp3lame-dev libxml2-dev libshout-dev libvorbis-dev libxslt-dev gcc g++ make procps

COPY	icecast-2.4.4.tar.gz /usr/src/icecast-2.4.4.tar.gz
COPY	ices-0.4.tar.gz /usr/src/ices-0.4.tar.gz

RUN	cd /usr/src \
	&& tar xzvf icecast-2.4.4.tar.gz \
	&& cd icecast-2.4.4 \
	&& ./configure \
	&& make \
	&& make install \
	&& rm -rf /usr/src/icecast-*

RUN     cd /usr/src \
        && tar xzvf ices-0.4.tar.gz \
	&& cd ices-0.4 \
        && ./configure --with-pic --with-lame \
        && make \
        && make install \
	&& rm -rf /usr/src/ices-*

RUN	useradd icecast; mkdir -p /var/log/icecast; chown icecast /var/log/icecast
ADD	icecast.xml /usr/local/etc/icecast.xml

RUN	apt-get -y install php php-cli php-common php-fpm lighttpd \
	&& mkdir -p /var/run/php \
	&& sed -i '/^;cgi.fix_pathinfo=1/c\cgi.fix_pathinfo=1' /etc/php/7.0/fpm/php.ini \
	&& sed -i '/^listen = /c\listen = \/var\/run\/php\/php7.0-fpm.sock' /etc/php/7.0/fpm/pool.d/www.conf \
	&& sed -i '/"bin-path" =>/d' /etc/lighttpd/conf-available/15-fastcgi-php.conf \
	&& sed -i 's/\/var\/run\/lighttpd\/php.socket/\/var\/run\/php\/php7.0-fpm.sock/g' /etc/lighttpd/conf-available/15-fastcgi-php.conf \
	&& lighty-enable-mod fastcgi \
	&& lighty-enable-mod fastcgi-php

ADD	html /var/www/html

ADD     bootstrap.sh /bootstrap.sh
RUN     chmod +x /bootstrap.sh
CMD     sh /bootstrap.sh

