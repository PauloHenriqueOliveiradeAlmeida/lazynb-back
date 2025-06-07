FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

RUN apk update && apk add --no-cache \
	postgresql-dev \
	libpq \
	oniguruma-dev \
	libzip-dev \
	curl \
	zip \
	unzip \
	bash \
	git \
	autoconf \
	g++ \
	make \
	&& pecl install mongodb \
	&& docker-php-ext-enable mongodb \
	&& docker-php-ext-install pdo pdo_pgsql mbstring zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json ./
RUN composer install --no-dev --optimize-autoloader
COPY . .

ENV ENVIROMENT=production
RUN echo "error_reporting = E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT" > /usr/local/etc/php/conf.d/error_reporting.ini
EXPOSE 8000

CMD ["php", "raven", "start"]
