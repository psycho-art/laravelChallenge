## Laravel Assessment

## Introduction
This is a Laravel-based project

Prerequisites
Before you begin, ensure you have the following installed:

PHP >= 8.0
Composer
Git
MySql

## Installation
Follow these steps to set up the project locally:

## Clone the repository to your local machine:
git clone https://github.com/your-username/your-repository-name.git
cd your-repository-name

## Use Composer to install the PHP dependencies:
composer install

## Copy the example environment file and configure it:
cp .env.example .env

## Open the .env file and set your environment-specific variables, particularly the database connection settings.
DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=your_database  
DB_USERNAME=your_username  
DB_PASSWORD=your_password

## Generate a unique application key:
php artisan key:generate

## Migrate the database and seed it with initial data:
php artisan migrate:fresh --seed

## Start the Laravel development server:
php artisan serve

Your application should now be running at http://localhost:8000.
