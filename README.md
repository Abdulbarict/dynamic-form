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
