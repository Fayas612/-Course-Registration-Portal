# Verification report

## Update on 5 November 2026

The updated application passed **19 tests with 168 assertions** on SQLite and on **MySQL Community Server 8.4.13**. This supersedes the earlier MariaDB-only engine limitation below. New coverage includes post create/view/edit/delete, publication and draft privacy, author assignment, post server validation, HTML escaping, guest/non-admin access denial, course detail/delete-confirmation pages and interactive administrator creation with a hashed password. All Blade views compiled and routes cached successfully. Preview records were backed up and imported before switching the active portal from SQLite to MySQL.

Docker/Railway deployment configuration and a GitHub Actions MySQL workflow were prepared. No Docker runtime or confirmed hosting/GitHub connection was available, so public deployment and hosted CI execution are not claimed. The live URL and remote repository URL remain pending those connections. Earlier verification below is retained as a historical record.

Verified on 4 November 2026. Local verification is not evidence of public deployment.

## Backend and database

- PHP 8.5.11, Laravel 13.40.0, Composer lockfile supplied.
- SQLite in-memory suite: 13 tests passed, 84 assertions.
- MariaDB 10.4.32 (MySQL-compatible) suite: the same 13 tests passed, 84 assertions, against an isolated verification database.
- Clean MariaDB migrations and sample course seeding completed. A schema-only export was produced without account or registration data.
- All Blade templates compiled successfully. Project PHP code was formatted with Laravel Pint.

The feature suite covers catalogue/API responses, visitor redirects from protected routes, non-admin denial, admin create/read/update/delete, invalid course data, successful visitor registration, invalid registration data, normalised duplicate emails, the same email on different courses, missing course handling, registration listing, cascade deletion, correct/incorrect admin login, logout, non-admin login denial and the database unique constraint. Two starter tests are also retained.

SQLite is the default test engine for convenience. MariaDB testing confirms the MySQL-compatible migration/query path; Oracle MySQL 8 was not separately available for verification. Before a demonstration, run the suite and application against your own MySQL environment. Test databases are refreshed: use a dedicated database, never production.

## Browser checks

Automated checks in a real Chrome browser confirmed the three-course catalogue, live search, no-results message, no horizontal overflow at 390px, mobile navigation and unauthenticated admin redirect. Desktop/mobile screenshots are in docs/screenshots. No page JavaScript errors occurred during those checks.

## Section C practicals

- C1: verified stacked cards at mobile width and three equal cards in a row at desktop width.
- C2: verified invalid input blocked submission and valid input reached the demonstration success page.
- C3: submitted the PHP form endpoint against the local MariaDB college database; received HTTP 200 and the success message, and confirmed the student row in the database.
- C4: supplied as integration files for an existing Laravel project, as the question assumes. The separate Product example was reviewed rather than installed into the capstone; PHP syntax checking is included in the final package checks.
- C5: dependency installation audited with no reported vulnerabilities. The Vite production build passed. A browser fetched through the Vite proxy and rendered both Keyboard and Mouse from the Express endpoint with no page errors.

The local sandbox restricts native esbuild filesystem traversal; the React dev-server check ran outside that sandbox. The supplied Vite scripts use its native JavaScript config loader. This is an environment constraint, not an application deployment claim.

## Document and archive

The nine-page answer script was rendered to page images and visually checked for layout and clipping. The archive excludes dependency installation folders, local databases, .env, logs and temporary verification files. composer.lock and package-lock.json retain dependency versions for installation.

Not performed: public hosting, a remote Git push, performance testing, a comprehensive production security audit, or the candidate's live demo/viva. These are not claimed as completed.
