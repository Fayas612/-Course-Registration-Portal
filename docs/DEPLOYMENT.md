# Publishing and repository handoff

The source is published at https://github.com/Fayas612/-Course-Registration-Portal on the main branch. The Laravel application has no live hosting URL yet; do not list localhost as a deployed URL. GitHub Pages cannot run its PHP/MySQL backend.

The local development branch `codex/coursepath-portal` tracks `origin/main`. The updated archive includes `output/CoursePath_Source.bundle` as an offline copy of the Git history. You can clone it with `git clone output/CoursePath_Source.bundle coursepath`. A Git repository and a hosted application are separate deliverables.

## Git
From a working copy, run `git init` if it is not already a repository. Ensure .env, vendor, node_modules, logs and database files are ignored. Stage the source, inspect `git diff --cached`, and commit with a meaningful message, for example `Build course portal with admin CRUD, registrations and API`. Create a repository in your account, add its remote URL with `git remote add origin YOUR_REPOSITORY_URL`, and push your branch. Add later commits for genuine changes as you develop. Do not invent earlier development history. Put the actual repository URL in the checklist.

## Laravel-compatible hosting
Choose a host that supports your composer.lock PHP requirements and a MySQL-compatible database. Upload or deploy the portal directory. Configure the web document root to portal/public; serving the project root can expose configuration files. Enable the host's Laravel/Apache/Nginx rewrite configuration so application routes reach public/index.php.

Set APP_ENV=production, APP_DEBUG=false, APP_URL to the HTTPS URL, a generated APP_KEY, and the database credentials in the host's protected environment. Use file session/cache as in .env.example, or configure a production equivalent. Set SESSION_SECURE_COOKIE=true when using HTTPS. Ensure storage and bootstrap/cache are writable by the web process, without making the entire application world-writable.

Run `composer install --no-dev --optimize-autoloader`, `php artisan key:generate` for a fresh deployment only (do not regenerate an existing application's key), `php artisan migrate --force`, and optionally `php artisan db:seed --force` for demo courses. Run `php artisan portal:admin` from a secure shell. Then run `php artisan optimize` once environment values are final. If you change environment values later, clear/rebuild configuration cache.

Check the live catalogue, mobile layout, registration success, duplicate errors, admin authentication, course CRUD and /api/courses. Confirm credentials and registrant contact details do not appear in the public API. Back up the database. Record the actual URL in the submission checklist and demonstrate it to the examiner.

The PHP development server is not a production hosting method. For the C5 React/Express exercise, use its separate deployment configuration if publishing it; it is not part of the Laravel capstone.

## Prepared Railway deployment

The repository now includes portal/Dockerfile, portal/docker/entrypoint.sh and portal/railway.json. Configure the Railway application service's root directory as `/portal` so it detects those files. Add a MySQL service, connect its private database variables to the application, and configure a public domain with HTTPS. The image uses PHP 8.5 and Apache, serves public/, installs production Composer dependencies and listens on the PORT supplied by the platform. The pre-deploy command runs migrations; it does not erase existing data.

Set these application variables in Railway's protected environment:

```text
APP_NAME=CoursePath
APP_ENV=production
APP_DEBUG=false
APP_URL=https://YOUR_ACTUAL_DOMAIN
APP_KEY=YOUR_PERSISTENT_GENERATED_APP_KEY
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
CACHE_STORE=database
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr
```

Replace `MySQL` in references if the database service has a different name. Generate a fresh key for a new deployment with `php artisan key:generate --show` and enter it as a secret; do not copy local passwords into Git. Create the production administrator using `php artisan portal:admin` in the deployed service shell. Sample courses can be added through the admin UI or with db:seed if wanted. News posts are created through the admin UI.

The container configuration is prepared but has not been built or deployed in this local environment. It needs a connected account and a remote repository destination. Once publishing succeeds, record the real URL in the submission checklist and verify catalogue, login, registration, news and /api/courses there. Official references: https://railway.com/guides/laravel and https://docs.railway.com/databases/mysql.
