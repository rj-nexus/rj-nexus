#!/bin/bash

# Əgər .env faylı yoxdursa, .env.example-dan yaradır
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Köhnə keşləri təmizləyir ki, installer yeni .env məlumatlarını oxuya bilsin
php artisan optimize:clear

# Installer-in .env və storage qovluqlarına yaza bilməsi üçün icazələri yeniləyir
chown -R www-data:www-data /var/www/html
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chmod 664 /var/www/html/.env

# Apache serverini işə salır
apache2-foreground
