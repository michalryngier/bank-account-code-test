FROM php:8.2-fpm-alpine
RUN docker-php-ext-install pdo pdo_mysql
RUN mkdir -p /app --mode g+s /app
COPY . /app
WORKDIR /app/public
CMD php -S 0.0.0.0:8000
EXPOSE 8000