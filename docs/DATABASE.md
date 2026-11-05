# Database documentation

Update 5 November 2026: the working portal now runs on actual MySQL Community Server 8.4.13. A posts migration adds the news feature: id primary key, user_id foreign key to users.id with restricted deletion, unique slug, title, excerpt, body, publication flag, publication timestamp and standard timestamps. Drafts are excluded from all public pages. The current schema export includes posts; it contains schema only, with no private account or registration rows.

Use the Laravel migrations as the normal installation path. The supplementary `portal/database/schema.sql` is a schema-only export from a clean MariaDB verification database. It contains no users, passwords or registration data. If importing it manually, create/select a fresh database first; it contains DROP TABLE statements and must not be imported into a database you need to preserve. Do not import it and then run the same create-table migrations: use one initial schema creation method. The migrations are recommended and satisfy the paper's database deliverable.

## Application tables

| Table | Columns and purpose |
| --- | --- |
| users | id: primary key; name, email: identity; password: hash; is_admin: administrator permission; framework authentication fields and timestamps |
| courses | id: primary key; title VARCHAR(150); description TEXT; duration VARCHAR(80); fee DECIMAL(10,2); start_date DATE; timestamps |
| registrations | id: primary key; course_id: foreign key; name VARCHAR(120); email VARCHAR(254); phone VARCHAR(30); timestamps |

The framework also includes cache, jobs, sessions, password reset and migration bookkeeping tables. The supplied environment uses file sessions/cache and synchronous jobs; those framework tables are not required by the portal workflows but are retained from the Laravel skeleton.

## Relationships and constraints

courses 1 --- many registrations. Every registration must reference an existing course. Deleting a course deletes its registrations through ON DELETE CASCADE. The UI confirmation explicitly states this effect.

UNIQUE(course_id, email) blocks a second registration for the same course and email. Email addresses are trimmed and lowercased before validation and persistence. The application checks uniqueness for a helpful error message, and the database enforces it even if simultaneous requests pass validation. A duplicate constraint exception is converted into the same validation error. The same email may register for different courses.

The users table has a unique email key. is_admin defaults to false. Only the interactive administrator command deliberately creates an administrator; ordinary user model creation does not grant that permission.

## Migration order

The Laravel skeleton creates users and infrastructure tables. The dated portal migrations then add is_admin, create courses, and create registrations. Rollback reverses that order so registrations are removed before courses. Sample courses are inserted by DatabaseSeeder; no administrator account is seeded.

## Backup and privacy

For a deployed portal, back up the database through your hosting provider or mysqldump. Backups may contain personal contact details and password hashes: store them privately. Do not include real registrant data or a private .env file in an assessment archive or public repository.
