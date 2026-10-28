# yatifoundation.alekh.dev

## Overview

A modern, fully responsive website for **Yati Foundation**, a non-profit organisation

## Technology stack

- PHP

## Repository structure

- `.gitignore`
- `about-us.php`
- `contact-us.php`
- `donate.php`
- `gallery.php`
- `Includes/code.php`
- `Includes/db.php`
- `Includes/footer.php`
- `Includes/head.php`
- `Includes/header.php`
- `LICENSE`

## Setup

1. Place the project in your XAMPP `htdocs` directory and start Apache and MySQL.
2. Restore the existing `yatifoundation` database and its core tables from your database backup. Then apply the migration described below; this repository does not include a full database backup.
3. The default local connection is `localhost`, MySQL user `root`, an empty password, and database `yatifoundation`. Override these with `DB_HOST`, `DB_USER`, `DB_PASS`, and `DB_NAME` environment variables when needed.
4. Visit the project through `http://localhost/<project-folder>/`.
5. Open `http://localhost/<project-folder>/admin/` to sign in. For the included default admin account, use `admin@gmail.com` / `admin@123` and change the password immediately.

Uploaded news, gallery, slider, and volunteer profile images are stored in `admin/upload`; keep that directory writable by PHP.

## Search engine files

- `sitemap.xml` lists the public website pages. Update its URLs if the production domain changes.
- `robots.txt` keeps admin pages and form handlers out of search crawls and points crawlers to the sitemap.

## Development notes

- Never commit secrets, access tokens, passwords, or production environment files.
- Check configuration and dependency manifests before deploying.

## License

Check this repository for a LICENSE file before redistributing or reusing the project.
## Foundation content features

Apply `Database/migrations/2026_10_26_foundation_features.sql` to the configured database before deploying this version. It creates the programs, impact metrics, and reports tables and adds follow-up status columns to the existing submission tables. Existing donations and volunteer applications begin as `Pending`; existing messages begin as `New`.

Admin pages: `admin/foundationcontent.php` manages programs, verified homepage metrics, and public PDF reports; `admin/submissionstatus.php` tracks incoming requests. Programs and reports are published from `/programs.php` and `/reports.php`.

Apply `Database/migrations/2026_10_27_donation_payments.sql` after the foundation content migration to add payment-provider transaction tracking.

The donation checkout supports Razorpay and Cashfree. Copy `.env.example` to the project-root `.env`, or configure the values in Admin → Payment settings. The admin page stores them in the ignored `.env` file; PHP loads it on each request. Payment options appear on the public donation form once the required provider credentials are saved. Use test credentials and Cashfree `sandbox` mode first. Set `SITE_BASE_URL` to the site's full public base URL; production callbacks and webhooks require public HTTPS.

Settings: `RAZORPAY_KEY_ID`, `RAZORPAY_KEY_SECRET`, `RAZORPAY_WEBHOOK_SECRET`, `CASHFREE_APP_ID`, `CASHFREE_SECRET_KEY`, `CASHFREE_WEBHOOK_SECRET`, `CASHFREE_ENVIRONMENT` (`sandbox` or `production`), and `SITE_BASE_URL`. Secret inputs are masked; leaving them blank preserves the saved value, while the explicit clear checkbox removes it. Never commit or share live `.env` secrets. Apache is configured to deny web requests for `.env` files.

Configure provider webhook URLs as `/payment/webhook.php?gateway=razorpay` and `/payment/webhook.php?gateway=cashfree`; use the corresponding webhook secrets. The server verifies provider responses before marking a donation `Received`. A payment must be captured/paid, not merely authorized or returned to the website.

Complete provider merchant onboarding and enable automatic capture as required. Verify successful, failed, abandoned and delayed payment flows with sandbox credentials before accepting live donations.
