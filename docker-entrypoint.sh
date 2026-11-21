#!/bin/bash

if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Hər açılışda installed.lock faylını avtomatik yaradır ki, installer bir daha açılmasın
mkdir -p /var/www/html/storage
echo '{"installed_at":"auto","version":"1.10.0"}' > /var/www/html/storage/installed.lock

php artisan storage:link --force
php artisan optimize:clear

chown -R www-data:www-data /var/www/html
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chmod 664 /var/www/html/.env

apache2-foreground
