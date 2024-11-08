# .docker/Dockerfile
FROM php:8.1-fpm

# Устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем весь проект в контейнер
COPY . /var/www/html

# Устанавливаем переменную окружения для Composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Устанавливаем зависимости
RUN composer install

# Открываем порт
EXPOSE 9000
