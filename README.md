# KCPL_Academy

# KCPL Academy

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-red?style=for-the-badge&logo=laravel">
  <img src="https://img.shields.io/badge/PHP-8.2-blue?style=for-the-badge&logo=php">
  <img src="https://img.shields.io/badge/MySQL-Database-orange?style=for-the-badge&logo=mysql">
  <img src="https://img.shields.io/badge/Vite-Frontend-purple?style=for-the-badge&logo=vite">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge">
</p>

# KCPL Academy – Modern Learning Management System (LMS)

KCPL Academy is a complete Learning Management System (LMS) developed using **Laravel 12**. The platform allows students to enroll in courses, instructors to create and manage educational content, and administrators to control the entire learning ecosystem from a centralized dashboard.

The system supports online learning, quizzes, assignments, certificates, payments, blogs, events, instructor management, analytics, notifications, and AI-powered student features.

---

# Features

## Student Module

- Student Registration & Login
- Student Dashboard
- Browse Courses
- Course Enrollment
- My Courses
- Video Learning
- Assignment Submission
- Quiz Attempts
- Certificate Download
- Event Registration
- Payment History
- Community Section
- AI Chat Assistant
- Notifications
- Profile Management

---

## Instructor Module

- Instructor Registration
- Instructor Dashboard
- Course Management
- Course Builder
- Student Management
- Quiz Management
- Assignment Management
- Event Builder
- Earnings Dashboard
- Analytics
- Reviews Management
- Notifications
- Bundle Management
- Profile Settings

---

## Admin Module

- Admin Dashboard
- User Management
- Student Management
- Instructor Management
- Course Management
- Bundle Management
- Course Categories
- Course Languages
- Enrollment Management
- Payment Management
- Payment Gateway Settings
- Certificate Management
- Reports & Analytics
- Newsletter Management
- Blog Management
- Blog Categories
- Banner Management
- Custom Pages
- Menu Builder
- Notifications
- Frontend Settings
- System Maintenance

---

## Frontend Features

- Home Page
- About Page
- Contact Page
- Course Catalog
- Instructor Listing
- Blog
- Events
- Testimonials
- FAQs
- Newsletter Subscription
- Dynamic Custom Pages

---

# Technology Stack

## Backend

- Laravel 12
- PHP 8.2+
- MySQL

## Frontend

- Blade Templates
- HTML5
- CSS3
- JavaScript
- Vite

## Authentication

- Laravel Fortify
- Laravel Sanctum

## Authorization

- Spatie Laravel Permission

## PDF

- Barryvdh Laravel DomPDF

## Payment Gateways

- Stripe
- Paystack

---

# Project Structure

```
KCPL Academy
│
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── vendor/
├── artisan
├── composer.json
├── package.json
└── vite.config.js
```

---

# Installation

## Clone Repository

```bash
git clone https://github.com/your-username/kcpl-academy.git
```

Move into project

```bash
cd kcpl-academy
```

Install PHP dependencies

```bash
composer install
```

Install Node dependencies

```bash
npm install
```

Copy Environment

```bash
cp .env.example .env
```

Generate Key

```bash
php artisan key:generate
```

Configure Database

Edit `.env`

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kcpl_academy
DB_USERNAME=root
DB_PASSWORD=
```

Run Migration

```bash
php artisan migrate
```

(Optional)

```bash
php artisan db:seed
```

Storage Link

```bash
php artisan storage:link
```

Run Project

```bash
php artisan serve
```

Compile Assets

Development

```bash
npm run dev
```

Production

```bash
npm run build
```

---

# User Roles

### Admin

- Manage platform
- Manage courses
- Manage instructors
- Manage students
- Configure payments
- Reports
- CMS

---

### Instructor

- Create courses
- Upload lessons
- Manage assignments
- Conduct quizzes
- Track students
- View earnings

---

### Student

- Purchase courses
- Learn online
- Submit assignments
- Attempt quizzes
- Download certificates
- Join events

---

# Main Functionalities

✔ Authentication

✔ Role Based Access Control

✔ Online Courses

✔ Assignments

✔ Quizzes

✔ Certificates

✔ Blog

✔ Events

✔ AI Chat

✔ Community

✔ Newsletter

✔ Reviews

✔ Analytics

✔ Payment Integration

✔ Notifications

---

# Packages Used

- Laravel Framework 12
- Laravel Fortify
- Laravel Sanctum
- Spatie Permission
- Barryvdh DomPDF
- Stripe PHP SDK
- Paystack PHP SDK
- Laravel Toaster Magic

---

# Security Features

- CSRF Protection
- Authentication Middleware
- Authorization Middleware
- Role-Based Access Control
- Form Validation
- Secure Password Hashing
- Session Protection

---

# Future Enhancements

- Mobile Application
- Live Classes
- Zoom Integration
- Google Meet Integration
- Discussion Forums
- Gamification
- Badges & Rewards
- AI Course Recommendations
- Multi-language Support
- Dark Mode

---

# Screenshots

Add screenshots inside

```
public/screenshots/
```

Example

```
screenshots/
├── home.png
├── dashboard.png
├── student.png
├── instructor.png
├── admin.png
├── courses.png
```

---

# Requirements

- PHP >= 8.2
- Composer
- Node.js
- npm
- MySQL
- Git

---

# License

This project is licensed under the MIT License.

---

# Author

**Shivam Mishra**

B.Tech CSE (AI & ML)

Galgotias University

GitHub:
https://github.com/shivammishhra5

LinkedIn:
https://linkedin.com/in/shivammishra044

---

# Acknowledgements

- Laravel
- Vite
- PHP
- MySQL
- Stripe
- Paystack
- Spatie
- Open Source Community

---

## Project Status

Current Status:

**Production Ready**

Actively maintained and continuously improved with new LMS features and performance enhancements.
