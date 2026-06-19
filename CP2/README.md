# ZPGC Services

A role-based support ticket portal built with PHP, MySQL, HTML, CSS, and JavaScript. Users sign up, log in, and are routed to a dashboard based on their role.

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | PHP (sessions, mysqli) |
| Database | MySQL (`users_db`) |
| Frontend | HTML5, CSS3, vanilla JavaScript |
| Server | XAMPP (Apache + MySQL) |

## Project Structure

```
CP2/
├── css/
│   ├── landing_page.css      # Public homepage
│   ├── login_signup.css      # Auth page (dual form layout)
│   └── main_interface.css    # Shared dashboard sidebar layout
├── js/
│   ├── script.js             # Login ↔ signup form toggle
│   └── behavior.js           # Collapsible sidebar on dashboards
├── logic/
│   ├── config.php            # MySQL connection ($conn)
│   └── user_mngmnt.php       # Signup & login handlers
├── pages/
│   ├── landing_page.php      # Public entry point
│   ├── login_signup.php      # Login and signup forms
│   ├── user.php              # User dashboard
│   ├── admin.php             # Administrator dashboard
│   └── techn.php             # Technician dashboard
└── images/                   # Logo assets
```

## Setup

1. Place the project in `C:\xampp\htdocs\CP2`.
2. Start Apache and MySQL in XAMPP.
3. Create the database and `users` table:

```sql
CREATE DATABASE users_db;
USE users_db;

CREATE TABLE users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name  VARCHAR(100) NOT NULL,
    email      VARCHAR(255) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    role       ENUM('user', 'admin', 'techn') NOT NULL
);
```

4. Open `http://localhost/CP2/pages/landing_page.php`.

## User Flow

```
landing_page.php
    ├── Login  → login_signup.php → user_mngmnt.php → role dashboard
    └── Signup → login_signup.php?form=signup → user_mngmnt.php → login
```

**Signup** — Collects name, email, password, and role. Passwords are hashed with `password_hash()`. Duplicate emails are rejected via session flash messages.

**Login** — Validates credentials with `password_verify()`. On success, stores `first_name`, `last_name`, `email`, and `role` in `$_SESSION` and redirects:

| Role | Dashboard |
|------|-----------|
| `admin` | `admin.php` |
| `techn` | `techn.php` |
| `user` | `user.php` |

## Role Dashboards

All three dashboards share `main_interface.css` and `behavior.js`. Each has a collapsible sidebar (60px collapsed, 250px expanded on hover) and an empty `.showcase` content area for future features.

| Page | Nav items |
|------|-----------|
| **user.php** | Home, Dashboard, Tickets, Messages, Settings, Logout |
| **admin.php** | Dashboard, Utilities, Analytics, Messages, Settings, Logout |
| **techn.php** | Dashboard, Tickets, Messages, Settings, Logout |

Each dashboard checks `$_SESSION['email']` and `$_SESSION['role']` before rendering. Unauthenticated or wrong-role visitors are redirected to `login_signup.php`.

## Key Files

| File | Responsibility |
|------|----------------|
| `config.php` | Creates `$conn` (mysqli). Fails with `die()` on connection error. |
| `user_mngmnt.php` | Handles `POST` signup/login. No HTML output — redirects only. |
| `login_signup.php` | Displays forms, reads session errors once via `session_unset()`. |
| `script.js` | Toggles `.form-box.active` between login and signup without reload. |
| `behavior.js` | Sidebar starts collapsed; expands on hover or hamburger click. |

## Known Limitations

- SQL queries use string interpolation instead of prepared statements.
- Signup allows self-selection of `admin` and `techn` roles.
- Logout link does not call `session_destroy()` — session persists after navigating away.
- Dashboard nav links and `.showcase` content are placeholders (`href="#"`).
- No input sanitization on form fields or error output (`htmlspecialchars`).

## Development Notes

- Run PHP logic before any HTML output to avoid header errors.
- Load JavaScript at the end of `<body>` so DOM elements exist when scripts run.
- Signup form opens directly via `login_signup.php?form=signup` (used by the landing page CTA).

## Inline Comment Labels

Source files use labeled comments for documentation:

| Label | Meaning |
|-------|---------|
| `FILE:` | File purpose and usage |
| `SYNTAX:` | Language construct — what the code means grammatically |
| `LOGIC:` | Application flow — why the code runs or what it achieves |
| `FLOW:` | Request/path routing between pages |
| `NAV:` | Role-specific navigation items |
| `SHARED:` | Assets reused across multiple pages |
