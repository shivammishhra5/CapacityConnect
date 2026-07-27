<div align="center">

# 🎓 KCPL Academy

### Modern Multi-Role Learning Management System (LMS) built on Laravel 12

A complete e-learning & course-marketplace platform — courses, events, quizzes, assignments, certificates, community Q&A, multi-gateway payments, instructor payouts, AI chat, and a full drag-and-drop Content/Frontend Manager — all in one codebase.

<p>
  <img alt="PHP" src="https://img.shields.io/badge/PHP-%5E8.2-777BB4?style=for-the-badge&logo=php&logoColor=white">
  <img alt="Laravel" src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white">
  <img alt="TailwindCSS" src="https://img.shields.io/badge/TailwindCSS-4.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white">
  <img alt="Vite" src="https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite&logoColor=white">
  <img alt="License" src="https://img.shields.io/badge/License-MIT-blue?style=for-the-badge">
</p>

<p>
  <img alt="Status" src="https://img.shields.io/badge/status-active-success?style=flat-square">
  <img alt="Sanctum" src="https://img.shields.io/badge/Auth-Sanctum%20%2B%20Fortify-8892BF?style=flat-square">
  <img alt="Permissions" src="https://img.shields.io/badge/RBAC-Spatie%20Permission-orange?style=flat-square">
  <img alt="Payments" src="https://img.shields.io/badge/Payments-8%2B%20Gateways-brightgreen?style=flat-square">
</p>

</div>

---

## 📖 Table of Contents

- [About the Project](#-about-the-project)
- [Key Highlights](#-key-highlights)
- [Feature Matrix](#-feature-matrix)
- [System Architecture](#-system-architecture)
- [Tech Stack](#-tech-stack)
- [User Roles & Permissions](#-user-roles--permissions)
- [Database Schema (Core Entities)](#-database-schema-core-entities)
- [Project / Folder Structure](#-project--folder-structure)
- [Getting Started](#-getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
  - [Environment Variables](#environment-variables)
  - [Running the App](#running-the-app)
- [Guided Setup Wizard](#-guided-setup-wizard)
- [Demo Accounts](#-demo-accounts)
- [Payment Gateways](#-payment-gateways)
- [API Overview](#-api-overview)
- [Frontend / Content Manager (CMS)](#-frontend--content-manager-cms)
- [Testing](#-testing)
- [Deployment Checklist](#-deployment-checklist)
- [Roadmap](#-roadmap)
- [Contributing](#-contributing)
- [Security](#-security)
- [License](#-license)
- [Credits](#-credits)

---

## 🧭 About the Project

**KCPL Academy** is a production-grade **Learning Management System (LMS)** and **course marketplace**, built with **Laravel 12**. It is designed for academies, training institutes, coaching centers, and individual instructors who want a self-hosted, fully customizable alternative to platforms like Udemy or Teachable.

The platform ships with **three dedicated portals**:

| Portal | Purpose |
|---|---|
| 🛡️ **Admin Panel** | Full platform control — users, courses, payments, payouts, CMS, reports, system maintenance |
| 👨‍🏫 **Instructor Panel** | Course & event builder, earnings, students, quizzes, assignments, analytics |
| 🧑‍🎓 **Student Panel** | Course learning, quizzes, assignments, certificates, community, habits, focus sessions, AI chat |

Everything — from course creation to payouts to CMS content — is manageable **without touching code**, thanks to a full-featured admin/Frontend Manager and a guided first-run **Setup Wizard**.

---

## ✨ Key Highlights

- 🎯 **Drag-and-drop Course & Event Builders** for instructors
- 🧩 **Role-based dashboards** for Admin / Instructor / Student with tailored analytics
- 💳 **8+ payment gateways** out of the box (Stripe, PayPal, Paystack, Flutterwave, SSLCommerz, Mollie, bKash) + offline payments
- 💰 **Instructor earnings & withdrawal management** with commission tracking
- 📚 **Course Bundles** — sell multiple courses as a discounted package
- 📝 **Quizzes, Assignments & Submissions** with grading workflows
- 🏆 **Auto-generated PDF Certificates** on course completion
- 📅 **Events module** — highlights, speakers, ticket bookings, email verification
- 💬 **Real-time-style Chat** between students & instructors (with file attachments)
- 🤖 **AI Chat Assistant** for students
- 🙋 **Community Q&A** — questions, answers, and voting (Stack Overflow-style)
- 🎯 **Habit Tracker & Focus Sessions** — productivity tools for learners
- 📰 **Blog Engine** — categories, comments, SEO-friendly posts
- 🖥️ **Frontend/CMS Manager** — homepage, menus, banners, custom pages, testimonials — all editable visually
- 🔔 **Notification system** with admin broadcast history
- 🛠️ **Guided Setup Wizard** — requirements check → DB config → permissions → admin creation → done
- 🔐 **RBAC** via Spatie Permission + Laravel Fortify (2FA, OTP login) + Sanctum (API tokens)
- 🧾 **Newsletter subscriptions**, account-deletion request workflow, cookie consent, and more

---

## 🧱 Feature Matrix

<table>
<tr>
<td valign="top" width="33%">

### 🛡️ Admin
- Dashboard & analytics/reports
- Course approval workflow
- User & instructor management
- Enrollment oversight
- Payments & payment gateway config
- Instructor withdrawal approvals
- Banner, menu, custom page & blog CMS
- Newsletter & notification broadcast
- Reviews & reply moderation
- Certificate templates
- System maintenance (cache, queue, logs)
- Impersonate users
- Auto-updater

</td>
<td valign="top" width="33%">

### 👨‍🏫 Instructor
- Course Builder (topics → lessons → quizzes)
- Event Builder (highlights, speakers, tickets)
- Bundles management
- Assignments & grading
- Quiz attempts review
- Student directory & chat
- Earnings & withdrawal requests
- Reviews received
- Analytics dashboard
- Profile & settings

</td>
<td valign="top" width="33%">

### 🧑‍🎓 Student
- Browse & enroll in courses/bundles
- Learn via lessons, quizzes, assignments
- Track progress & download certificates
- Book & attend events
- Community Q&A participation
- Chat with instructors + AI Chat
- Habit tracker & focus sessions
- Payment history
- Notifications & account settings

</td>
</tr>
</table>

---

## 🏗️ System Architecture

KCPL Academy follows Laravel's classic **MVC** pattern with a clean **role-namespaced controller layer**, a **service-driven payment layer**, and a **Blade + Tailwind CSS** frontend compiled via **Vite**.

```
┌─────────────────────────────────────────────────────────────────────┐
│                            CLIENT (Browser)                         │
│      Blade Views + Tailwind CSS + Vite + Axios (AJAX/API calls)     │
└───────────────────────────────┬───────────────────────────────────┘
                                 │  HTTPS
┌───────────────────────────────▼───────────────────────────────────┐
│                          LARAVEL 12 APPLICATION                     │
│                                                                       │
│  ┌───────────────┐   ┌────────────────┐   ┌──────────────────┐     │
│  │ routes/web.php │   │routes/admin.php│   │routes/instructor │     │
│  │ routes/api.php │   │routes/student.php│  │routes/auth.php  │     │
│  └───────┬────────┘   └────────┬───────┘   └─────────┬────────┘     │
│          │                     │                      │              │
│  ┌───────▼─────────────────────▼──────────────────────▼────────┐    │
│  │                     Http/Controllers                          │    │
│  │   Admin/*  Instructor/*  Student/*  Front/*  Api/*  Auth/*    │    │
│  │   Setup/*  (Guided installer)                                  │    │
│  └───────────────────────────┬───────────────────────────────────┘    │
│                               │                                        │
│  ┌────────────────────────────▼──────────────────────────────────┐   │
│  │   Middleware: Sanctum · Fortify (2FA/OTP) · Spatie Permission  │   │
│  └────────────────────────────┬──────────────────────────────────┘   │
│                               │                                        │
│  ┌────────────────────────────▼──────────────────────────────────┐   │
│  │                          Eloquent Models                        │   │
│  │  User · Course · Lesson · Quiz · Assignment · Enrollment ·      │   │
│  │  Payment · Bundle · Event · BlogPost · CommunityQuestion ·      │   │
│  │  Habit · FocusSession · ChatMessage · Notification · ...        │   │
│  └────────────────────────────┬──────────────────────────────────┘   │
│                               │                                        │
│  ┌────────────────────────────▼──────────────────────────────────┐   │
│  │        Payment Gateway Adapters (Stripe / PayPal / Paystack /   │   │
│  │        Flutterwave / SSLCommerz / Mollie / bKash / Offline)     │   │
│  └───────────────────────────────────────────────────────────────┘   │
└───────────────────────────────┬───────────────────────────────────┘
                                 │
┌───────────────────────────────▼───────────────────────────────────┐
│   Database (SQLite / MySQL / PostgreSQL)  ·  Queue  ·  Cache        │
│   File Storage (local/S3 for certificates, attachments, media)      │
└─────────────────────────────────────────────────────────────────────┘
```

**Design principles used across the codebase:**

- **Role-first routing** — separate route files (`admin.php`, `instructor.php`, `student.php`, `auth.php`, `api.php`) keep each portal isolated and easy to secure.
- **Thin controllers, model-rich domain** — business rules live close to Eloquent models/relationships.
- **API-ready** — a parallel REST API (`routes/api.php`, `Http/Controllers/Api/*`) powers AJAX interactions and can back a future SPA/mobile app.
- **Pluggable payments** — every gateway is isolated behind its own controller/fields, all writing to a unified `payments` table.
- **CMS-driven frontend** — homepage sections, menus, banners and pages are database-driven (`FrontendSetting`, `Menu`, `MenuItem`, `Banner`, `CustomPage`) instead of hardcoded.

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| **Backend Framework** | Laravel 12 (PHP ^8.2) |
| **Authentication** | Laravel Fortify (2FA, OTP login), Laravel Sanctum (API tokens) |
| **Authorization** | Spatie `laravel-permission` (Roles & Permissions) |
| **Frontend Build** | Vite 7, Tailwind CSS 4 |
| **JS/HTTP** | Axios, vanilla JS (`resources/js/app.js`) |
| **PDF Generation** | `barryvdh/laravel-dompdf` (certificates, invoices) |
| **Payments** | Stripe, PayPal, Paystack (`yabacon/paystack-php`), Flutterwave, SSLCommerz, Mollie, bKash |
| **UX Utilities** | `devrabiul/laravel-toaster-magic` (toast notifications), `spatie/laravel-cookie-consent` |
| **Database** | SQLite (default/dev) — MySQL/PostgreSQL supported |
| **Queue & Cache** | Database driver (Redis-ready) |
| **Testing** | PHPUnit 11 |
| **Tooling** | Laravel Pint (code style), Laravel Pail (log viewer), Laravel Sail |

---

## 👥 User Roles & Permissions

Role-based access control is powered by **Spatie Laravel Permission**, seeded via `RoleSeeder`.

| Role | Description |
|---|---|
| **Admin** | Full system access — manages every module listed above |
| **Instructor** | Manages own courses, events, bundles, students, earnings (subject to admin approval) |
| **Student** | Learner role — enrolls, learns, and engages with community/AI features |

Instructors go through an **approval workflow** (`courses.pending`, `users.approval_reason` columns) before their courses/withdrawals go live — giving admins full quality control over the marketplace.

---

## 🗄️ Database Schema (Core Entities)

The application ships **90+ migrations**. Key entity groups:

```
Users & Access            Courses & Learning          Commerce
├─ users                  ├─ courses                  ├─ payments
├─ roles / permissions    ├─ course_categories        ├─ enrollments
├─ personal_access_tokens ├─ course_languages          ├─ bundles
└─ notifications          ├─ course_topics             ├─ bundle_courses
                          ├─ lessons                    ├─ bundle_enrollments
Events                    ├─ lesson_progress            └─ instructor_withdrawals
├─ events                 ├─ quizzes / quiz_questions
├─ event_highlights       ├─ quiz_attempts / answers   Community & Engagement
├─ event_speakers         ├─ assignments               ├─ community_questions
├─ event_bookings         ├─ assignment_files           ├─ community_answers
└─ (instructor <> event)  ├─ assignment_submissions     ├─ community_votes
                          └─ assignment_submission_files ├─ reviews / review_replies
Content & CMS                                            ├─ blog_posts / categories / comments
├─ frontend_settings       Productivity                  ├─ conversations / chat_messages
├─ banners                 ├─ habits / habit_logs        └─ chat_attachments
├─ menus / menu_items      └─ focus_sessions
├─ custom_pages
└─ newsletter_subscribers  Platform
                           ├─ platform_settings
                           ├─ payment_gateway_settings
                           ├─ admin_notification_histories
                           └─ account_deletion_requests
```

---

## 📁 Project / Folder Structure

```
KCPL_Academy/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Admin panel controllers (30+)
│   │   ├── Api/             # REST API controllers (incl. Api/Instructor/*)
│   │   ├── Auth/            # Login, OTP, password reset, verification
│   │   ├── Front/           # Public-facing website controllers
│   │   ├── Instructor/      # Instructor panel controllers
│   │   ├── Setup/           # First-run guided installer
│   │   └── Student/         # Student panel controllers
│   └── Models/               # 45+ Eloquent models
├── config/                   # app, auth, permission, services, setup, etc.
├── database/
│   ├── migrations/           # 90+ migration files
│   ├── seeders/               # Roles, admin, categories, blog, settings
│   └── factories/
├── resources/
│   ├── css/app.css           # Tailwind entry
│   ├── js/app.js             # Vite/JS entry
│   └── views/
│       ├── admin/ instructor/ student/  # Portal views
│       ├── auth/ courses/ events/ blog/ bundles/
│       ├── components/ layouts/ partials/
│       ├── emails/            # Mail templates
│       └── setup/             # Installer wizard views
├── routes/
│   ├── web.php     admin.php    instructor.php
│   ├── student.php api.php      auth.php   install.php
├── public/                   # Compiled assets, admin theme assets
├── vite.config.js
├── composer.json
└── package.json
```

---

## 🚀 Getting Started

### Prerequisites

Make sure you have the following installed:

- **PHP** >= 8.2 with extensions: `openssl`, `pdo`, `mbstring`, `tokenizer`, `json`, `curl`, `fileinfo`, `bcmath`
- **Composer** 2.x
- **Node.js** >= 18 & **npm**
- **SQLite** (default) or **MySQL/PostgreSQL**
- **Git**

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/<your-username>/kcpl-academy.git
cd kcpl-academy

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Create SQLite database (default) — or configure MySQL in .env
touch database/database.sqlite

# 7. Run migrations & seeders
php artisan migrate --seed

# 8. Link storage (for uploaded media/certificates)
php artisan storage:link
```

> 💡 **Tip:** You can also run the automated Composer setup script which chains steps 2, 4–8 automatically:
> ```bash
> composer run setup
> ```

### Environment Variables

Key `.env` values to configure:

```env
APP_NAME="KCPL Academy"
APP_ENV=production
APP_URL=http://localhost

DB_CONNECTION=sqlite      # or mysql / pgsql
# DB_HOST=127.0.0.1
# DB_DATABASE=admin
# DB_USERNAME=root
# DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=

# Payment Gateways (configure only what you use)
STRIPE_KEY=
STRIPE_SECRET=
PAYPAL_CLIENT_ID=
PAYPAL_SECRET=
PAYSTACK_PUBLIC_KEY=
PAYSTACK_SECRET_KEY=
FLUTTERWAVE_PUBLIC_KEY=
FLUTTERWAVE_SECRET_KEY=
SSLCOMMERZ_STORE_ID=
SSLCOMMERZ_STORE_PASSWORD=
MOLLIE_KEY=
BKASH_APP_KEY=
BKASH_APP_SECRET=
```

> Gateway credentials can also be managed **without editing `.env`** via **Admin → Payment Gateway Settings** (`payment_gateway_settings` table).

### Running the App

```bash
# Development (runs server + queue + logs + vite together)
composer run dev

# OR run individually
php artisan serve          # http://127.0.0.1:8000
npm run dev                # Vite dev server
php artisan queue:listen   # Queue worker

# Production build
npm run build
```

---

## 🧙 Guided Setup Wizard

On first launch, if the app isn't installed yet, KCPL Academy redirects to a **step-by-step Setup Wizard** (`Http/Controllers/Setup/*`, `routes/install.php`):

1. **Welcome** — intro screen
2. **Requirements Check** — verifies PHP version & required extensions
3. **Permissions Check** — verifies writable folders (`storage/`, `bootstrap/cache/`)
4. **Environment Setup** — DB & mail configuration form
5. **Database Migration** — runs migrations & seeders
6. **Final Step** — creates the admin account and marks `storage/installed`

This makes deployment friendly for non-technical users — no manual `.env` editing required.

---

## 🔑 Demo Accounts

| Role | Email | Password |
|---|---|---|
| 🛡️ Administrator | `admin@eduex.com` | `password` |
| 👨‍🏫 Instructor | `instructor@eduex.com` | `password` |
| 🧑‍🎓 Student | `student@eduex.com` | `password` |

> ⚠️ Change these credentials immediately in any production/public deployment.

---

## 💳 Payment Gateways

KCPL Academy supports **multi-gateway checkout**, configurable per deployment:

| Gateway | Use Case |
|---|---|
| **Stripe** | Global card payments |
| **PayPal** | Global wallet payments |
| **Paystack** | Africa (Nigeria, Ghana, etc.) |
| **Flutterwave** | Africa-wide payments |
| **SSLCommerz** | Bangladesh |
| **bKash** | Bangladesh mobile wallet |
| **Mollie** | Europe |
| **Offline/Manual** | Bank transfer, cash — admin-approved |

All transactions funnel into a unified `payments` table with gateway-specific columns, powering **commission calculation** and **instructor withdrawal** workflows.

---

## 🔌 API Overview

A parallel JSON API lives under `routes/api.php` (200+ lines) secured with **Sanctum**, covering:

```
/api/auth/*              → Login, register, OTP
/api/courses/*           → Browse, enroll, progress
/api/bundles/*           → Bundle listing & purchase
/api/events/*            → Event listing & booking
/api/community/*         → Q&A, answers, votes
/api/chat/*              → Student ↔ Instructor messaging
/api/habits/*            → Habit tracker CRUD
/api/focus/*             → Focus session tracking
/api/notifications/*     → Notification feed
/api/instructor/*        → Instructor-scoped API (dashboard, earnings, students...)
```

This makes the platform **mobile-app-ready** — the same endpoints can power a future Flutter/React Native app.

---

## 🎨 Frontend / Content Manager (CMS)

Non-technical admins can fully customize the public website from the Admin Panel:

- **Menus** — desktop, mobile, footer, quick-links (`Menu`, `MenuItem`)
- **Banners** — homepage/hero carousels
- **Homepage Sections** — highlights, testimonials, featured categories (`FrontendSetting`)
- **Custom Pages** — rich-text pages with custom slugs (`CustomPage`)
- **Blog** — categories, posts, comments, SEO metadata
- **About / Contact / FAQ** — editable content blocks
- **Newsletter** — subscriber capture & broadcast

---

## 🧪 Testing

```bash
# Run the full test suite
composer test

# Or directly
php artisan test
```

Tests are located in `tests/Feature` and `tests/Unit`, powered by **PHPUnit 11**.

---

## ✅ Deployment Checklist

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Configure a production database (MySQL/PostgreSQL recommended over SQLite)
- [ ] Set up real mail credentials (`MAIL_MAILER`)
- [ ] Configure at least one payment gateway
- [ ] Run `php artisan config:cache route:cache view:cache`
- [ ] Set up a queue worker (Supervisor) for `QUEUE_CONNECTION=database`
- [ ] Run `php artisan storage:link`
- [ ] Set proper folder permissions on `storage/` and `bootstrap/cache/`
- [ ] Configure HTTPS & set `SESSION_ENCRYPT=true` if applicable
- [ ] Change all demo account passwords

---

## 🗺️ Roadmap

- [ ] Native mobile app (Flutter) consuming the existing REST API
- [ ] Live/streaming classes integration
- [ ] Multi-language (i18n) frontend
- [ ] Coupon & discount engine
- [ ] Affiliate/referral program
- [ ] Advanced analytics (cohort retention, funnel tracking)

---

## 🤝 Contributing

Contributions are welcome!

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

Please run `./vendor/bin/pint` before submitting to keep code style consistent.

---

## 🔒 Security

If you discover a security vulnerability, please **do not open a public issue**. Instead, email the maintainers directly so it can be addressed responsibly.

---

## 📄 License

This project is open-sourced software licensed under the **[MIT license](LICENSE)**.

---

## 🙏 Credits

- Built on [Laravel](https://laravel.com)
- Authorization by [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- Auth by [Laravel Fortify](https://laravel.com/docs/fortify) & [Sanctum](https://laravel.com/docs/sanctum)
- PDF generation by [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)
- UI toasts by [laravel-toaster-magic](https://github.com/devrabiul/laravel-toaster-magic)

<div align="center">

**Made with ❤️ using Laravel**

</div>
