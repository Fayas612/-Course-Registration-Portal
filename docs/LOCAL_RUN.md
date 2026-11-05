# Run the completed portal locally

The current working copy is connected to **MySQL Community Server 8.4.13** at 127.0.0.1:3308. The application uses the dedicated `coursepath` database account and `coursepath_live` database. The previous SQLite preview was backed up before switching, and its courses/users/registrations were imported without resetting the data.

## On this computer

Run `./Start-Portal.ps1` from the project folder in PowerShell. It starts this project's already-configured portable MySQL server if needed and starts Laravel on port 8000. Both processes run in the background. This does not install a Windows service or start automatically after reboot.

- Course catalogue: http://127.0.0.1:8000
- News: http://127.0.0.1:8000/news
- Admin sign in: http://127.0.0.1:8000/login
- Admin dashboard after sign in: http://127.0.0.1:8000/admin
- Public API: http://127.0.0.1:8000/api/courses

A local administrator was created. Its email and generated password are in `tmp/LOCAL_ADMIN_ACCESS.txt`, outside the source repository and submission archive. Sign in to manage courses, registrations and news. No password is embedded in application source or seeded for public deployments.

The portable MySQL binary, live database, backups and local credentials stay under the ignored `tmp/` directory. Do not delete that directory if you want to retain this local database. The archive does not contain the runtime or private records.

## On another computer from the ZIP

Install PHP 8.4.1+ compatible with the lockfile (PHP 8.5 recommended), Composer and MySQL 8.4. Open the `portal` directory, run `composer install`, copy `.env.example` to `.env`, create an empty database and set its credentials. Then run:

```text
php artisan key:generate
php artisan migrate --seed
php artisan portal:admin
php artisan serve --host=127.0.0.1 --port=8000
```

The root startup helper recognises the portable installation configured on this computer. On another computer, configure your own running MySQL server in `.env` first. Use `php artisan portal:admin` to create your own administrator interactively.

Official MySQL download and ZIP installation documentation:
https://dev.mysql.com/downloads/mysql/8.4.html
https://dev.mysql.com/doc/refman/8.4/en/windows-installation.html

## Tests

`php artisan test` uses an isolated SQLite in-memory database by default. The full suite was also run against a dedicated MySQL 8.4.13 database with a separate test-only user: 19 tests, 168 assertions passed. The GitHub Actions workflow uses MySQL 8.4 too. Never configure tests to use `coursepath_live` or a production database; tests rebuild their configured test database.
