FROM php:8.2-fpm

ARG USER_ID=1000

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    unzip \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -\
    && apt-get install -y nodejs \
    && npm install -g yarn

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN useradd -u ${USER_ID} -m appuser && echo "alias ll='ls -al'" >> /home/appuser/.bashrc

USER appuser

EXPOSE 9000

CMD ["php-fpm"]