# CoursePath - Course Registration Portal

Section D reference project for the Full Stack Development Final Assessment.

Update 5 November 2026: the current local system runs on actual MySQL Community 8.4.13, with the preview data preserved. The administrator account is ready locally; see ../docs/LOCAL_RUN.md for access. An admin dashboard and news/posts management have been added. Public news is at /news; administrators manage drafts, publish posts and edit/delete them at /admin/posts. Courses now have separate view and deletion-confirmation pages. The full suite passes 19 tests and 168 assertions on SQLite and MySQL. Git and hosting handoff status is tracked in ../docs/REQUIREMENTS_STATUS.md.

## Requirements and architecture
PHP 8.4.1+ for the supplied lockfile (PHP 8.5 recommended), with PDO MySQL, mbstring, openssl, tokenizer, XML, ctype, fileinfo, curl and zip; Composer 2; MySQL 8 or compatible MariaDB. Use a PHP version compatible with composer.lock (PHP 8.5 was used for verification). No Node build is required for the portal: Bootstrap CSS/JS and custom assets are bundled in public/assets. Laravel renders the frontend with Blade and serves the JSON API from the same application.

## Local setup (PowerShell)
1. Open a terminal in this portal folder. Run `composer install` (downloads dependencies pinned by composer.lock).
2. Run `Copy-Item .env.example .env`. Enter your MySQL host, port, database, username and password in .env. Create the database: `CREATE DATABASE course_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;`.
3. Run `php artisan key:generate`.
4. Run `php artisan migrate --seed` to create the tables and three sample courses.
5. Run `php artisan portal:admin`. Enter an administrator name, email and a password of at least 12 characters. No default administrator password is distributed.
6. Run `php artisan serve --host=127.0.0.1 --port=8000`.
7. Open http://127.0.0.1:8000. Admin login: /login. API: /api/courses.

Keep the database server running. File-based session/cache storage means no queue worker or extra cache service is needed. Use migrate (without --seed) when sample courses are not wanted. The development server is for local use.

## Optional SQLite quick preview
Create an empty database/database.sqlite file. In .env set DB_CONNECTION=sqlite and DB_DATABASE to its absolute path. Then run key:generate, migrate --seed and portal:admin as above. SQLite is useful for a preview and automated tests; the assessment's required database target is MySQL. Switch back to MySQL and run the migrations there before demonstrating the required database.

## Features and routes
- GET /: responsive course catalogue with live JavaScript search.
- GET/POST /courses/{course}/register: visitor registration and validation.
- GET/POST /login and POST /logout: session authentication, hashed passwords and login throttling.
- /admin/courses: authenticated admin course CRUD, including protected create and edit pages.
- /admin/registrations: admin-only paginated registration list.
- GET /api/courses: public JSON array of all courses; rate limited to 60 requests/minute per client.
- GET /up: framework health endpoint; this alone does not verify database availability.

## Data model and business rules
users.id is the primary key for administrator identities; is_admin defaults to false. courses.id is a primary key. registrations.id is a primary key, and registrations.course_id references courses.id. The composite unique key (course_id, email) prevents duplicate registration. Emails are trimmed and lowercased before validation and storage. The same email may join different courses. Deleting a course cascades to registrations; the UI asks for confirmation and states this consequence. All course fields are validated on the server. Course fees use DECIMAL(10,2), displayed as LKR; start dates may be historical when editing an existing course. There is no payment processing.

## Security and access
The admin CLI creates accounts without hard-coded credentials; there is no public signup. Both authentication and an is_admin check protect all course mutations and registration lists. Laravel supplies CSRF tokens, session renewal on login, invalidation on logout, query parameter binding and escaped Blade output. Login and registration endpoints are throttled. The public API exposes course fields only. Configure HTTPS, a dedicated database account, APP_DEBUG=false and appropriate SESSION_SECURE_COOKIE=true for production. Do not commit .env, private keys, logs or real registrant data.

## Automated verification
Run `php artisan test` for the default SQLite in-memory suite. It covers public catalogue/API, authentication, non-admin denial, CRUD, course validation, registration validation, email normalisation, duplicate prevention, cross-course registration and cascading deletion. Tests refresh their configured database: never point them at production. See ../docs/VERIFICATION.md for results and database-engine coverage.

## Deployment and Git handoff
See ../docs/DEPLOYMENT.md for publishing instructions. No remote repository or live URL is included. Supply real URLs in ../docs/SUBMISSION_CHECKLIST.md after publishing. See ../docs/DEMO_AND_VIVA.md for the five-minute demonstration.

## File map
app/Models: Eloquent models and relationships; app/Http/Controllers: request handling and validation; app/Http/Middleware/EnsureAdmin.php: authorisation; database/migrations: schema; database/seeders: sample courses; routes/web.php: browser routes; routes/api.php: JSON endpoint; resources/views: Bootstrap Blade templates; public/assets: local frontend assets; tests/Feature/PortalTest.php: behavioural tests.

The migrations are the authoritative database deliverable. A supplementary database/schema.sql is supplied for inspection/import; when using Laravel setup, use migrations on an empty database instead of importing that schema first.

## Credits
Laravel framework and skeleton: MIT. Bootstrap 5.3.8: MIT; licence bundled in public/assets/BOOTSTRAP-LICENSE.txt. Original project code in this reference implementation is provided for learning and review. Read your course's assessment and AI-use rules before submission.
