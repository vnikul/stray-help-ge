FROM php:8.0-fpm

ARG user
ARG uid

COPY ./php/scripts/ /tmp/scripts/

RUN chmod +x -R /tmp/scripts/

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

RUN echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list && \
    apt update && \
    apt install symfony-cli

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

ENTRYPOINT ["/tmp/scripts/init.sh"]

EXPOSE 9000

CMD ["php-fpm"]
