# Dynamic Form Builder

A dynamic form builder web application built using Laravel 9 and MySQL 8, with a modern JavaScript frontend powered by Node.js 18.x.

![Laravel](https://img.shields.io/badge/Laravel-9.x-red)
![PHP](https://img.shields.io/badge/PHP-8.1-blue)
![Node](https://img.shields.io/badge/Node.js-18.x-green)
![License](https://img.shields.io/badge/license-MIT-lightgrey)

## 📌 Features

-   Drag-and-drop form creation
-   Field types: text, email, textarea, select, radio, etc.
-   Form saving and editing
-   AJAX-based dynamic field rendering
-   Laravel queue and job integration
-   Seeder setup for development

---

## 📋 Requirements

| Tool     | Version            |
| -------- | ------------------ |
| PHP      | 8.1.x              |
| Laravel  | 9.x                |
| MySQL    | 8.x                |
| Composer | Latest             |
| Node.js  | 18.x               |
| NPM      | Comes with Node.js |

---

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/Abdulbarict/dynamic-form.git
cd dynamic-form
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Setup environment file

```bash
cp .env.example .env
php artisan key:generate
```

Update .env with your database credentials:

```bash

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

```

### 4. Set up the database

```bash

php artisan migrate
php artisan db:seed

```

This will create the necessary tables and seed sample form data.

### 5. Install frontend dependencies

```bash
npm install
npm run dev
```

Use npm run build for production.

### 6. Serve the application

```bash
php artisan serve
```

Then visit: http://localhost:8000

## 🔐 Demo Credentials

Use the following credentials to log in as an admin:

-   **Email**: `admin@example.com`
-   **Password**: `password`

> ⚠️ For security, be sure to change or remove this account in production.

## Queue & Jobs

To enable Laravel's queue system using the database driver:

### 1. Update .env:

```bash
QUEUE_CONNECTION=database
```

### 2. Generate required table:

```bash
php artisan queue:table
php artisan migrate

```

### 3. Run the queue worker:

```bash
php artisan queue:work
```
