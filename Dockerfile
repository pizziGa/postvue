FROM node:lts-alpine

COPY . /app

WORKDIR /vuejs

RUN npm install && npm run build

FROM richarvey/nginx-php-fpm:1.7.2
COPY /app/laravel /app

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /app/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/app/start.sh"]