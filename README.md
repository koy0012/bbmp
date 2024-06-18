# Laravel 10, BBMP - Bagong Pilipinas

## Prerequisite
- PHP 8.1
- MYSQL
- Composer 2
- npm 10.2.3 (Node LTS 20.11.0)

## Setup
- composer install
- setup .env (app name & database credentials)
- `php artisan generate key`
- `php artisan migrate`
- `php artisan db:seed`

## Development
- `php artisan optimize` (every time you change `web.php`, call this or your routes won't be able to update)
- `npm run dev`

## Production 
### Before Production
It's recommended to be done on local computer for shared hosting user.
- `npm run build:prod`

### In Server
- composer install
- setup .env (app name & database credentials), credentials must be enclosed with double quotes "password".
   - .env must be in production environment
- `php artisan generate key`
- `php artisan migrate`
- `php artisan db:seed`


