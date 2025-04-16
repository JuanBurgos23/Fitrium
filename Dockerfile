FROM php:8.2-apache

# Instalación de extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    nano \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar configuración personalizada de Apache
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar entrypoint personalizado
COPY .docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Darle permisos de ejecución
RUN chmod +x /usr/local/bin/entrypoint.sh


# Usar el entrypoint personalizado
ENTRYPOINT ["entrypoint.sh"]

# Arrancar Apache
CMD ["apache2-foreground"]