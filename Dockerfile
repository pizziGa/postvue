FROM node:lts-alpine

COPY . /app

RUN npm install && npm run build

FROM webdevops/php-nginx:8.3

COPY --from=0 --chown=1000:1000 /app/laravel /app

COPY init_instavue.conf /opt/docker/etc/supervisor.d/
RUN chmod +x /app/start.sh

# Image config
ENV WEB_DOCUMENT_ROOT /app/public

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1