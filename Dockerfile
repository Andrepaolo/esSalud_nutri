# Usa la imagen base de PHP con Apache
FROM php:8.2-apache

# Instala las dependencias necesarias y herramientas adicionales
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    nano \
    default-mysql-client \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd pdo pdo_mysql

# Habilita mod_rewrite en Apache
RUN a2enmod rewrite

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Copia los archivos del proyecto a la imagen
COPY . /var/www/html

COPY .env.dockerexample /var/www/html/.env

# Establece permisos adecuados para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache
    
# Establece el directorio de trabajo
WORKDIR /var/www/html

# Exponer el puerto 80 del contenedor (puedes cambiarlo luego)
EXPOSE 80
