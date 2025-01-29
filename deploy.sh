#!/bin/bash

set -e  # Detén el script en caso de errores

echo "Actualizando código desde el repositorio..."
git fetch origin
git reset --hard origin/main

echo "Instalando dependencias..."
composer install
npm install

echo "Actualizando permisos..."
chown -R www-data:www-data /var/www/html/ProyectoFinalRenovado
chmod -R 755 /var/www/html/ProyectoFinalRenovado

echo "Despliegue completo."