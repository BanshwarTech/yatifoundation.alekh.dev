# Yati Foundation

A modern, fully responsive website for **Yati Foundation**, a non-profit organisation
working in education, healthcare and community livelihoods.

Built with **PHP + MySQL** and a custom, mobile-first front-end on top of Bootstrap 5.

## ✨ Features

- Modern, responsive design (mobile, tablet, desktop) with a custom design system
- Dynamic hero slider, impact counters, gallery lightbox and news cards
- Public pages: Home, About, Volunteer, Donate, Gallery, News, Contact
- Admin dashboard to manage sliders, gallery, news, donations, volunteers and contacts
- Secure backend: prepared statements, hashed passwords and validated file uploads

## 🛠️ Tech Stack

| Layer     | Technology                          |
| :-------- | :---------------------------------- |
| Backend   | PHP 8 (mysqli, prepared statements) |
| Database  | MySQL / MariaDB                     |
| Front-end | Bootstrap 5.3 + custom CSS/JS       |
| Server    | Apache (XAMPP)                      |

## 🚀 Getting Started (XAMPP)

1. Place this folder inside `htdocs/` (e.g. `xampp/htdocs/YatiFoundation`).
2. Start **Apache** and **MySQL** from the XAMPP control panel.
3. Open **phpMyAdmin** and create a database named `yatifoundation`.
4. Import the schema from [`Database/database.php`](Database/database.php).
5. Visit `http://localhost/YatiFoundation/`.

### Database configuration

Connection settings live in [`Includes/db.php`](Includes/db.php) and default to the
standard XAMPP values (`localhost` / `root` / no password). For production you can
override them with environment variables: `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`.

### Admin access

- URL: `http://localhost/YatiFoundation/admin/`
- Email: `admin@gmail.com`
- Password: `admin@123`

> The default password is stored as a bcrypt hash. **Change it after first login**
> via the admin panel's *Change Password* page.

## 📁 Project Structure

```text
/
├── index.php              # Home page
├── AboutUs.php            # About page
├── Donate.php             # Donation form
├── Vounteer.php           # Volunteer form
├── Gallery.php            # Gallery
├── News.php               # News & updates
├── ContactUs.php          # Contact form + map
├── Includes/
│   ├── db.php             # DB connection + helpers (upload, flash)
│   ├── head.php           # Shared <head> + preloader
│   ├── header.php         # Responsive navbar + login modal
│   ├── footer.php         # Shared footer + scripts
│   └── code.php           # Public form handlers (secure)
├── admin/                 # Admin dashboard (Bootstrap 5)
├── assets/                # CSS, JS, images, fonts
├── vendor/                # Bootstrap & jQuery
└── Database/database.php  # SQL schema + seed data
```

## 🔒 Security notes

This codebase was hardened from its original form:

- All SQL uses **prepared statements** (no more string-concatenated queries).
- Admin passwords are **bcrypt-hashed**; legacy plaintext logins auto-upgrade.
- Uploads are validated by **real MIME type** and stored with random filenames.
- Admin pages enforce a **session guard**, and debug output was removed.
