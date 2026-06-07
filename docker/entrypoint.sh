#!/bin/bash
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage

# Asegurar que el directorio de tapas sea escribible (para uploads y descargas de Open Library)
mkdir -p /var/www/html/public/assets/img/tapas
chown -R www-data:www-data /var/www/html/public/assets/img/tapas
chmod -R 775 /var/www/html/public/assets/img/tapas

vendor/bin/phinx migrate
vendor/bin/phinx seed:run
exec apache2-foreground
