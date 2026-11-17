# Asiri Medical – Pharmacy Management System

A web-based Pharmacy Management System (PMS) for **Asiri Medical**, built with PHP and MySQL.
It has a back office for pharmacy staff (point of sale, stock, purchasing, returns, reports) and a customer-facing online shop for ordering medicine (work in progress).

> Originally developed in 2020–2021 by **Jmax Software Solution** for PHP 7.2 / XAMPP.
> This repository continues that project and upgrades it step by step.

---

## Features

**Back office (staff)**
- Dashboard with sales and stock charts
- Point of sale (POS) with invoice printing
- Products, categories, sub-categories and product images
- Purchases from suppliers and agents, stock tracking with expiry dates and re-order levels
- Sales returns and purchase returns
- Payments, sales reports, buy/sell reports
- User management with role-based access
- Database backup from Settings

**Online shop (customers, in progress)**
- Sign up with email verification, login
- Shopping cart, shipping details, order tracking
- Payment gateway integration (sample)

### User roles

| Role | Access |
|---|---|
| 0, 1 | Admin: full dashboard (`home.php`) |
| 2, 3 | Storekeeper / cashier: limited dashboard (`lawLevelHome.php`) |

---

## Quick start (Windows + XAMPP)

**Requirements:** [XAMPP](https://www.apachefriends.org/) installed at `C:\xampp` (tested with PHP 8.2 / MariaDB 10.4).

1. Clone the repository anywhere. It does **not** need to be inside `htdocs`.
2. Double-click **`RUN.bat`**.
3. The browser opens at **http://localhost:8000/**.

`RUN.bat` will:
- create `.env` from `.env.example` on the first run,
- start XAMPP's MySQL if it is not already running,
- create the `db_pms` database from `model/db_pms.sql` on the first run (later runs keep your data),
- apply any new database migrations (`model/migrate.php`),
- serve the project with XAMPP's PHP on port 8000, using the same access rules as `.htaccess`.

Close the `RUN.bat` window to stop the website. Run **`STOP.bat`** to stop MySQL.

If XAMPP is installed somewhere else, or port 8000 is taken, edit `XAMPP=` / `PORT=` at the top of `RUN.bat`.

### Demo logins (from the sample database)

| Username | Password | Role |
|---|---|---|
| `admin` | `1234` | Admin |
| `jmax`  | `1234` | Super admin |
| `keep`  | `1234` | Storekeeper |
| `cash`  | `1234` | Cashier |

> Passwords are stored as bcrypt hashes. Change these demo passwords (Profile → Change Password) before using real data.

### Manual setup (Apache / shared hosting)

1. Upload or copy the project, for example to `C:\xampp\htdocs\AsiriMedicalPM`.
2. Create a MySQL database and import `model/db_pms.sql`.
3. Copy `.env.example` to `.env` and set `DB_HOST`, `DB_NAME`, `DB_USER` and `DB_PASS`. Keep `APP_DEBUG=false`.
4. Run the migrations:
   - with SSH: `php model/migrate.php`
   - without SSH: set `MIGRATE_TOKEN` in `.env`, open `/model/migrate.php?token=<value>` once, then clear the token.
5. Open the site. `.htaccess` blocks access to `.env`, `model/`, SQL files and backups, and `.user.ini` sets the PHP options for PHP-FPM hosts.

## Configuration

All settings live in `.env`, or in real environment variables, which take priority. See `.env.example`.

| Key | Default | Purpose |
|---|---|---|
| `APP_DEBUG` | `false` | Show PHP errors in the page (local only) |
| `APP_TIMEZONE` | `Asia/Colombo` | Dates on invoices and reports |
| `DB_HOST` / `DB_PORT` | `127.0.0.1` / `3306` | Database server |
| `DB_NAME` / `DB_USER` / `DB_PASS` | `db_pms` / `root` / *(empty)* | Database credentials |
| `MIGRATE_TOKEN` | *(empty)* | Enables the web migration runner while set |

## Security

- Staff passwords are hashed with `password_hash`. Old plain-text passwords are upgraded automatically.
- Every staff page and handler requires login, and access is checked per role (`model/auth.php`).
- Only a Super Admin can create, edit or delete Super Admin accounts.
- Login, user management, profile and backup forms are protected with CSRF tokens.
- Sessions are regenerated on login and use `HttpOnly` / `SameSite=Lax` cookies (`Secure` on HTTPS).
- Database backups download directly and are never stored on the server.
- PHP files can't run from the product image upload folder.

---

## Project structure

```
├── index.html              Public landing page
├── RUN.bat / STOP.bat      One-click launcher (XAMPP)
├── .env.example            Configuration template (copy to .env)
├── .htaccess / .user.ini   Apache access rules and PHP settings
├── _launcher/              Built-in server router and logs (used by RUN.bat)
├── model/
│   ├── bootstrap.php       Config, errors, sessions, CSRF, e() escaping
│   ├── db.php              Database layer (db_query, db_row, db_all, db_exec)
│   ├── db_connection.php   Legacy include, loads db.php
│   ├── auth.php            Staff login, password hashing, role checks
│   ├── migrate.php         Migration runner
│   ├── migrations/         Schema and data upgrades
│   └── db_pms.sql          Database schema and sample data
├── view/
│   ├── AdminUser/          Back-office pages (POS, products, stock, reports…)
│   └── Customer/           Online shop pages and payment gateway
├── control/
│   ├── AdminUser/          Form handlers and AJAX endpoints
│   └── Customer/           Customer handlers
└── assets/                 Bootstrap, jQuery, Chart.js, CanvasJS, fonts, images
```

---

## Versions

| Version | Notes |
|---|---|
| `v1.0` | The original project, kept as-is in `AsiriMedicalPM_V1.0.rar` |
| `main` | Working copy, being upgraded |

---

## Roadmap

**Priority**
- [x] One-click launcher that runs on PHP 8 with no code changes
- [x] Fix the broken "Visit Us Today!" link on the landing page (now opens the shop)
- [ ] Customer accounts: the login and sign-up pages are mock-ups with no customer table yet. The shop works as guest checkout.
- [ ] Product image upload: real size and type validation, and allow updates without a new image

**Phase 1: Foundation** ✅
- [x] Central config (`.env`) and one database layer with prepared-statement helpers (`model/db.php`)
- [x] Hashed passwords, secure login and logout, role-based access on every page and handler
- [x] Database migrations (`model/migrate.php`)
- [x] Streamed backups (nothing stored in the web root), `.htaccess` / router access rules
- [x] Removed test files and the mock customer login and sign-up pages

**Phase 2: SQL injection**
- [ ] Convert the remaining queries in views and handlers to prepared statements

**Phase 3: XSS and CSRF**
- [ ] Escape all output and add CSRF tokens to the remaining forms

**Phase 4: Deployment**
- [ ] Product image upload: real size and type validation, and allow updates without a new image
- [ ] Docker (`Dockerfile` + `docker-compose.yml`)
- [ ] Remove leftover debug alerts

---

## Tech stack

PHP · MySQL/MariaDB (mysqli) · Bootstrap 4 · jQuery · Chart.js · CanvasJS · Font Awesome

## Author

**Jayashanka Anushan** ([@JayashankaAnushan19](https://github.com/JayashankaAnushan19)), Jmax Software Solution
