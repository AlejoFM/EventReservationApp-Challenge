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

## **Installation**

To install Event Reservation App, follow these steps:
Its recommended to have Docker and Docker Compose installed on your machine.

1. Clone the repository: **`git clone https://github.com/AlejoFM/project-title.git`**
2. Docker Compose: **`docker-compose up --build`**
3. Open another terminal and run the following commands :
    Powershell :
    ```
        docker-compose exec webserver php artisan key:generate; `
        docker-compose exec webserver php artisan jwt:secret; `
        docker-compose exec webserver php artisan config:clear; `
        docker-compose exec webserver php artisan config:cache; `
        docker-compose exec webserver php artisan l5-swagger:generate; `
        docker-compose exec webserver php artisan migrate:fresh --seed; `
    ```
    For unix based systems : 
    ``` 
        docker-compose exec webserver php artisan key:generate && \
        docker-compose exec webserver php artisan jwt:secret && \
        docker-compose exec webserver php artisan config:clear && \
        docker-compose exec webserver php artisan config:cache && \
        docker-compose exec webserver php artisan l5-swagger:generate && \
        docker-compose exec webserver php artisan migrate:fresh --seed 
        
    ```

4. Enjoy the project!

If you dont have Docker installed, you can follow the steps below:

1. Clone the repository: **`git clone https://github.com/AlejoFM/project-title.git`**
2. move to the folder: **`cd EventReservationApp-Challenge/backend`**
3. Install composer dependencies: **`composer install`**
4. Create the database: **`php artisan migrate:fresh --seed`**
5. Create the keys: **`php artisan key:generate`**
6. Create the JWT secret: **`php artisan jwt:secret`**
7. Create the config: **`php artisan config:clear`**
8. Create the cache: **`php artisan config:cache`**
9. Create the Swagger documentation : **`php artisan l5-swagger:generate`**
9. Now your backend is ready to use!

For the frontend, follow the steps below:

1. Clone the repository: **`git clone https://github.com/AlejoFM/project-title.git`**
2. move to the folder: **`cd EventReservationApp-Challenge/frontend`**
3. Install the dependencies: **`npm install`**
                             **`npm install -g @angular/cli`**
4. Run the project: **`npm run start`** or **`ng serve -o`**
5. Now your frontend is ready to use!

## **Usage**

To use the Event Reservation App, follow these steps:

1. Run the project: **`docker-compose up --build`**
2. You can access the project at **`http://localhost:4200`**
3. Now, you will have two users ready to use the app:
    - Role : **`admin`**
    - Username: **`juan@example.com`**
    - Password: **`password123`**

    - Role : **`user`**
    - Username: **`manu@example.com`**
    - Password: **`password123`**

## **Testing**

To test for the Event Reservation App backend, follow these steps:

1. Run the project: **`docker-compose up --build`**
2. Run the tests: **`docker-compose exec webserver php artisan test`**
3. Enjoy!