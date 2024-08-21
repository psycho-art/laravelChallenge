## Laravel Assessment

## Introduction
This is a Laravel-based project

Prerequisites
Before you begin, ensure you have the following installed:

PHP >= 8.0
Composer, 
Git, 
MySql, 

## Installation
Follow these steps to set up the project locally:

## Clone the repository to your local machine:
git clone https://github.com/psycho-art/laravelChallenge.git

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

## Admin Credentials and Link
Admin Link: http://127.0.0.1:8000/login
Email: admin@example.com  
Password: password

## Start the Laravel development server:
php artisan serve

Your application should now be running at http://localhost:8000.

## Design Patterns Used

## MVC (Model-View-Controller) Pattern
This project follows the MVC (Model-View-Controller) design pattern, The MVC pattern separates the application into three main components: Models, Views, and Controllers.

## Example in This Project:
Authentication: The AuthController handles user-related actions like registration and login It interacts with the User model to authenticate user and redirects user based on their role

Task Management: The TaskController handles CRUD operations for tasks. It interacts with the Task model to fetch, create, update, and delete tasks. The data is then passed to the view, where tasks are displayed in a list or detail view.

Invitations: The InvitationController manages the logic for creating and sending invitations. It interacts with the Invitation model and ensures that the invitation data is properly stored and displayed.
