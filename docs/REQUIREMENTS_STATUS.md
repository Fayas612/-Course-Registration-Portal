# Requirement implementation status

Updated 5 November 2026.

| Requirement | Status | Evidence |
| --- | --- | --- |
| 1. MySQL tables and migrations | Implemented and running | Oracle MySQL Community 8.4.13; courses and registrations migrations; primary keys, course foreign key and composite unique constraint |
| 2. Admin course CRUD and server validation | Implemented and tested | Admin list/detail/add/edit/delete confirmation pages; validated create and update requests |
| 3. Visitor course registration and duplicate protection | Implemented and tested | Name/email/phone validation, normalised email, unique validation and database constraint |
| 4. Admin login and access restrictions | Implemented and tested | Laravel session authentication, admin authorisation middleware, CLI account creation, local account ready |
| 5. Responsive Bootstrap frontend and JavaScript | Implemented | Navbar, responsive course cards, live search, mobile collapse and local Bootstrap assets |
| 6. GET /api/courses | Implemented and tested | HTTP 200 JSON array of course records; no registrant data exposed |
| 7. Git and public deployment | Source committed in a local Git repository; external publication pending | Branch codex/coursepath-portal; source and CI/deployment files supplied. A connected hosting account and repository destination are still required for a live URL and remote repository link |
| Extra news/posts management | Implemented and tested | Public news list/detail; admin create/view/edit/delete; drafts, publication status, author relationship and escaped plain-text content |

## Verification

19 tests passed with 168 assertions on SQLite and on actual MySQL 8.4.13. The suite covers original course/registration/authentication requirements plus post lifecycle, draft visibility, admin-only access, server validation, safe rendering, course detail/delete confirmation and secure administrator creation. Local preview data was backed up and imported before switching databases.

Browser verification also confirmed local administrator sign-in, the dashboard counters, course actions, the news list and the post editor's draft/published controls. The dashboard screenshot is supplied in docs/screenshots/admin-dashboard.png. The server returned HTTP 200 for public news and the public API returned all three courses.

## Publishing handoff

`portal/Dockerfile`, `portal/docker/entrypoint.sh` and `portal/railway.json` prepare the application for Laravel-compatible hosting. `.github/workflows/tests.yml` prepares MySQL CI. Docker and hosted CI were not executed locally because those runtimes/accounts are not connected; the PHP application and MySQL tests were verified directly on this computer.

GitHub and Railway were located as available integrations but are not confirmed connected. There is no public deployment URL or remote repository URL to report yet. The Docker setup does not use Cloudflare Sites, because this project requires Laravel/PHP and MySQL.
