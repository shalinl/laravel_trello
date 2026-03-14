# Laravel Trello API

A RESTful Task Management API built with Laravel.
This project demonstrates authentication, task management, comments, file uploads, and API testing using modern Laravel best practices.

---

## Features

* User Authentication using Laravel Sanctum
* Task CRUD (Create, Read, Update, Delete)
* Comment system for tasks
* File upload support
* RESTful API structure
* API validation and error handling
* Feature testing using PHPUnit

---

## Tech Stack

* Laravel
* PHP
* MySQL / SQLite
* Laravel Sanctum
* PHPUnit
* Faker

---

## API Modules

### Authentication

* User Registration
* User Login
* Token-based authentication (Sanctum)

### Tasks

* Create Task
* Update Task
* Delete Task
* Get all tasks
* Get task by ID

### Comments

* Add comment to task
* Update comment
* Delete comment
* Get comments by task

### Files

* Upload files to comments

---

## Testing

Feature tests are implemented using PHPUnit.

Example test cases include:

* Create Task
* Update Task
* Delete Task
* Get Tasks
* File Upload Testing

Run tests using:

php artisan test

---

## Installation

Clone the repository:

git clone https://github.com/shalinl/laravel_trello.git

Navigate to the project folder:

cd laravel_trello

Install dependencies:

composer install

Create environment file:

cp .env.example .env

Generate application key:

php artisan key:generate

Run migrations:

php artisan migrate

Start the development server:

php artisan serve

---

## Upcoming Features

The following improvements are planned for future versions:

* Role-based permissions (Admin / User)
* Email notifications using Laravel Queue
* Background job processing
* Task activity logs
* Task priority and status management
* API documentation using Swagger
* Docker support

---

## Author

Shalin

Backend Developer specializing in Laravel and API development.
