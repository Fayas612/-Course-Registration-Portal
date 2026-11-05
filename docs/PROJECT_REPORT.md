# Capstone implementation and requirement mapping

CoursePath lets visitors find courses and register while administrators manage the catalogue. Laravel serves both Blade pages and the REST endpoint from one application. Bootstrap assets are bundled locally, so the frontend does not depend on an external CDN at runtime.

| Assessment requirement | Implementation and evidence |
| --- | --- |
| Related MySQL tables and migrations | portal/database/migrations creates courses and registrations, primary keys, foreign key and composite unique constraint; docs/DATABASE.md explains the design |
| Admin course CRUD | CourseController plus admin course Blade views; validated create/update and protected delete |
| Visitor registration | RegistrationController and registration form; validates name/email/phone, normalises email and handles duplicates |
| Admin login and access protection | AuthController, Laravel session guard, EnsureAdmin middleware and interactive portal:admin command |
| Responsive Bootstrap frontend and JavaScript | layouts/app.blade.php, courses/index.blade.php, local Bootstrap assets and portal.js live search |
| REST endpoint | routes/api.php implements GET /api/courses with JSON and HTTP 200 |
| Hosting and Git | Source is ready for handoff; real deployment and remote repository are pending the candidate's accounts and URLs |
| Demo and viva | docs/DEMO_AND_VIVA.md provides a five-minute sequence and explanation prompts; the candidate must perform it |

## Request flow

A browser request matches a web route. Public course requests load Eloquent models and return Blade views. Management requests first pass authentication and administrator checks. Form submissions are protected by CSRF tokens and validated before persistence. A successful write redirects with a flash message; invalid input redirects back with errors and old input. Registration writes also rely on the unique database constraint to prevent simultaneous duplicates.

The API uses a stateless API route group. A request to GET /api/courses loads course records and returns a JSON array. An empty catalogue returns HTTP 200 and `[]`. The response deliberately excludes all registration and user fields. Requests exceeding the configured rate limit receive HTTP 429.

## API example

Request: `GET /api/courses`, header `Accept: application/json`.

Example response (IDs and dates depend on the database):

```json
[
  {
    "id": 1,
    "title": "Full Stack Development",
    "description": "Build responsive interfaces, Laravel applications and REST APIs with practical projects.",
    "duration": "12 weeks",
    "fee": "45000.00",
    "start_date": "2026-12-04T00:00:00.000000Z"
  }
]
```

## Scope and choices

Fees display in LKR; there is no payment flow. The assessment does not require email confirmation, capacity limits or a public student account, so registration is a visitor workflow. Deleting a course cascades to registrations and requires a browser confirmation. Search filters the loaded catalogue locally. A production catalogue with very large data volumes could instead add server-side search and pagination; the assessment asks the API to return all courses.

Public deployment, a repository URL and the live viva cannot be represented by local files. They remain clearly marked in the submission checklist. Earlier assignments cannot be reconstructed because no separate assignment briefs were supplied.
