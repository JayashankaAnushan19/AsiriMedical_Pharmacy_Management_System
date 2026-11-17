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
- start XAMPP's MySQL if it is not already running,
- create the `db_pms` database from `model/db_pms.sql` on the first run (later runs keep your data),
- serve the project with XAMPP's PHP on port 8000.

Close the `RUN.bat` window to stop the website. Run **`STOP.bat`** to stop MySQL.

If XAMPP is installed somewhere else, or port 8000 is taken, edit `XAMPP=` / `PORT=` at the top of `RUN.bat`.

### Demo logins (from the sample database)

| Username | Password | Role |
|---|---|---|
| `admin` | `1234` | Admin |
| `jmax`  | `1234` | Super admin |
| `keep`  | `1234` | Storekeeper |
| `cash`  | `1234` | Cashier |

> Change these before using the system with real data.

### Manual setup (Apache instead of RUN.bat)

1. Copy the project to `C:\xampp\htdocs\AsiriMedicalPM`.
2. In phpMyAdmin, create a database named `db_pms` and import `model/db_pms.sql`.
3. Open `http://localhost/AsiriMedicalPM/`.

On PHP 8.1+, add `mysqli_report(MYSQLI_REPORT_OFF);` to the top of `model/db_connection.php`, or set `auto_prepend_file` to `_launcher/prepend.php`. Otherwise a failed query stops the page with an exception.

---

## Project structure

```
├── index.html              Public landing page
├── RUN.bat / STOP.bat      One-click launcher (XAMPP)
├── _launcher/              Launcher helpers (PHP 8 compatibility, logs)
├── model/
│   ├── db_connection.php   Database connection (root / no password / db_pms)
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

**Security** (needed before any online deployment)
- [ ] Prepared statements for all SQL queries (prevent SQL injection)
- [ ] Hash passwords (`password_hash` / `password_verify`)
- [ ] Move secrets and database credentials to a config file outside the web root
- [ ] Keep database backups outside the web root

**Clean-up**
- [ ] Remove test and experiment files (`view/test*.html`, `printTest*.php`, `Test_ImageUpload*`)
- [ ] Remove leftover debug alerts

---

## Tech stack

PHP · MySQL/MariaDB (mysqli) · Bootstrap 4 · jQuery · Chart.js · CanvasJS · Font Awesome

## Author

**Jayashanka Anushan** ([@JayashankaAnushan19](https://github.com/JayashankaAnushan19)), Jmax Software Solution
