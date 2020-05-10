FROM php:7.4.1-cli-alpine3.11

COPY . /usr/src/app

WORKDIR /usr/src/app

RUN apk add --no-cache curl git

RUN curl -sS https://getcomposer.org/installer | php && \
   chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

RUN composer dumpautoload && composer install

CMD [ "php", "./index.php" ]