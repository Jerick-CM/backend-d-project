composer install
composer dump-autoload
php artisan cache:clear
php artisan config:clear
php artisan key:generate
php artisan migrate
php artisan passport:install
php artisan azure:sync
php artisan db:seed --class=ProductionDataSeeder
php artisan config:cache