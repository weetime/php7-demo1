#+++++++++++++++++++++++++++++++++++++++
# Dockerfile for webdevops/php:centos-7
#    -- automatically generated  --
#+++++++++++++++++++++++++++++++++++++++

FROM centos:7

RUN set -x \
    # Install php environment
    && yum-install \
        # Install tools
        ImageMagick \
        GraphicsMagick \
        ghostscript \
        # Install php (cli/fpm)
        php-cli \
        php-fpm \
        php-json \
        php-intl \
        php-curl \
        php-mysqlnd \
        php-mongodb \
        php-memcached \
        php-mcrypt \
        php-gd \
        php-pgsql \
        php-mbstring \
        php-bcmath \
        php-soap \
        sqlite \
        php-xmlrpc \
        php-xsl \
        geoip \
        php-ldap \
        php-memcache \
        php-pecl-redis \
        ImageMagick \
        ImageMagick-devel \
        ImageMagick-perl \
        php-pear \
        php-pecl-apcu \
        php-devel \
        gcc \
        php-pear \
    && pecl channel-update pecl.php.net \
    && pear channel-update pear.php.net \
    && pear upgrade-all \
    && pear config-set auto_discover 1 \
    && pecl install imagick \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer \
    # Cleanup
    && yum erase -y php-devel gcc \
    # Enable php services
    && docker-service enable syslog \
    && docker-service enable cron \
    && docker-run-bootstrap \
    && docker-image-cleanup

EXPOSE 9000