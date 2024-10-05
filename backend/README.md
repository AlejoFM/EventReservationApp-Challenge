# EventReservationApp

# Description
SPA Built in Angular 18, with Angular Material for the UI and an API REST built in Laravel, with JWT Authentication.

# Tools used
- Docker
- Docker Compose
- Angular 18
- Angular Material
- Laravel
- JWT Tymon Package
- Swagger
- Eloquent ORM

# Prende el docker y levanta y buildea
docker compose up --build

# migra la base de datos y seedeala
docker-compose exec webserver php artisan migrate --seed 

# Ejecuta los test
docker-compose exec webserver php artisan test

# Generar las rutas para Swagger : 
docker-compose exec webserver php artisan l5-swagger:generate