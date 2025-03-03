# Application Task management system

## Installation Steps
1. Clone the repository
2. create .env file and set the database credentials
3. Run `composer install`
4. Run `php artisan migrate --seed`
5. Run `php artisan serve`
6. open the postman and import the `task-management-system.postman_collection.json` file or you can use the following link to import the collection: [Task Management System](https://documenter.getpostman.com/view/24019984/2sAYdiopTu)



## Usage
1. Run `php artisan migrate --seed` to create the tables and seed the database with the default data
1.1. mangers [
    email: manager1@gmail.com, password: 12345678 
    email: manager2@gmail.com, password: 12345678
    ]
1.2. users [
    email: employee1@example.com, password: 12345678
    email: employee2@example.com, password: 12345678
    ...
    email: employee8@example.com, password: 12345678
    ]
2. Run `php artisan serve` to start the server

3. open erd.png file to view the database schema



