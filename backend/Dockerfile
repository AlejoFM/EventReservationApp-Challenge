# Dockerfile
FROM php:8.2-apache

WORKDIR /var/www

# Instala las dependencias necesarias
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && a2enmod rewrite

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia los archivos de la aplicación
COPY . /var/www

COPY .env.example /var/www/.env 

COPY .env.example /var/www/.env.testing 

# Configuración de Apache
COPY ./docker/000-default.conf /etc/apache2/sites-available/000-default.conf


# Ejecuta Composer
RUN composer install --no-scripts --no-autoloader \
    && composer dump-autoload \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache 


RUN sed -i 's/DB_DATABASE=.*/DB_DATABASE=EventReservationApp_local/g' /var/www/.env.testing

RUN php artisan l5-swagger:generate


    
EXPOSE 80

CMD ["apache2-foreground"]
