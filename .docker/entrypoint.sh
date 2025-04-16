#!/bin/bash

# Este script se ejecuta al inicio del contenedor para realizar tareas previas antes de arrancar Apache.

# Clonar el repositorio si no existe el proyecto (opcional, solo si realmente lo necesitas)
if [ ! -d "/var/www/html" ]; then
    echo "Repositorio no encontrado. Clonando el repositorio..."
    git clone https://github.com/JuanBurgos23/Fitrium.git /var/www/html
fi

# Establecer permisos para los directorios de Laravel
echo "Configurando permisos para los directorios de Laravel..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

# Si la clave de la aplicación no está generada, generarla
if [ ! -f /var/www/html/.env ]; then
    echo "Archivo .env no encontrado. Generando uno desde .env.example..."
    cp /var/www/html/.env.example /var/www/html/.env
    php artisan key:generate
fi

# Ejecutar migraciones de la base de datos si es necesario
echo "Ejecutando migraciones de Laravel..."
php artisan migrate --seed


# Si es necesario, ejecutar otros comandos aquí como se indique
# Por ejemplo, ejecutar los seeders:
# echo "Ejecutando seeders..."
# php artisan db:seed --force

# Ahora, ejecutar el comando principal para Apache
echo "Arrancando Apache..."
exec "$@"
