# Getting started

## Installation

Switch to the repo folder


Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Create database in your database serve called : karma_score

Make sure to put same name in .env file

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate:fresh --seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

To test my api you can access at http://localhost:8000/api/v1/user/1/karma-position
    
    you can change user id from 1 to another existing user
    if you want to specify number of users you can do it like : 
    http://localhost:8000/api/v1/user/1/karma-position?numberOfRecord=8

There is another api to show view :    
 
    http://localhost:8000/user/3
    

