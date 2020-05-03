FROM php:7.4-cli
COPY . /usr/src/api
WORKDIR /usr/src/api

EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80", "-t", "/usr/src/api/public", "/usr/src/api/public/index.php"]
