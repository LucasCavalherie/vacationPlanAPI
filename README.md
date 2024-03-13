# Vacation Plan API

## Introduction

The Vacation Plan API is an application developed to manage vacation plans, allowing users to create, view, update, and delete vacation plans. This API was developed using the Laravel framework.

## Running the application

To run the application locally, follow these steps:

1. Clone this repository:

    ```bash
    git clone https://github.com/LucasCavalherie/vacationPlanAPI.git
    ```

2. Copy the example environment file and configure your environment variables:

    ```bash
    cp .env.example .env
    ```
   Open the `.env` file and configure the environment variables.


2. Enter the docker file

    ```bash
    cd docker
    ```

3. Create your containers

    ```bash
    docker-compose up -d
    ```
   Inside the docker-compose.yml file, we define the users and password of your database, you can change this data.


4. Enter your mysql container

    ```bash
    docker exec -it mysql_container_hash bash
    ```

5. Access your mysql and create your database

    ```bash
    create database database_name
    ```

6. Enter your php container

    ```bash
    docker exec -it php_container_hash bash
    ```

7. Install Composer dependencies:

    ```bash
    composer install
    ```

8. Generate an application key:

    ```bash
    php artisan key:generate
    ```

9. Run the database migrations:

    ```bash
    php artisan migrate --seed
    ```

## Architecture used

The Vacation Plan API is organized as follows:

- `routes/`: Contains the application's route definition files.
- `app/http/Controller`: Contains the controllers, which receive data from the routes.
- `app/DTO`: Contains the Data Transfer Objects (DTOs), encapsulating data to be transferred.
- `app/Services`: Contains the system services, which receive a DTO and call the repository if necessary.
- `app/Repositories`: Contains the system repositories, which access the database.
- `database/migrations/`: Contains the database migration files for creating and modifying tables.
