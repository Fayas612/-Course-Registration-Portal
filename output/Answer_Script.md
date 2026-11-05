# Full Stack Development - Reference Answer Script

Prepared for the supplied nine-page assessment. Reference and practice material; review the assessment rules before use. Sections A-C are stated as closed book, and the Section D lab prohibits AI tools.

Candidate name: ____________________

Student ID: ____________________

Batch: ____________________

Date: ____________________

## Section A - Multiple choice (25 marks)

1. **A** - A website mainly presents content; a web application supports interactive data processing.
2. **C** - <h1> is the highest-level heading and is the intended answer; CSS can change its visual size.
3. **B** - The alt attribute supplies alternative text.
4. **D** - #main targets the element with id="main".
5. **B** - The order is content, padding, border, margin.
6. **C** - .col-md-6 uses six of twelve columns from the medium breakpoint.
7. **A** - const prevents reassignment of the variable binding.
8. **D** - The statement replaces the contents of the existing demo element with Hi.
9. **B** - A domain name and web hosting is the best offered option. A hosting-provided subdomain also works; buying a custom domain is optional.
10. **C** - PHP variable names begin with $.
11. **A** - XAMPP bundles Apache, MariaDB/MySQL, PHP and Perl.
12. **D** - SELECT retrieves rows.
13. **B** - $_POST holds ordinary form fields sent using POST.
14. **C** - A primary key uniquely identifies each row.
15. **A** - JOIN combines related rows.
16. **B** - Laravel follows the Model-View-Controller pattern.
17. **D** - php artisan make:controller UserController
18. **C** - password_hash() creates a password hash; password_verify() checks it.
19. **B** - POST normally creates a resource.
20. **C** - 404 means not found.
21. **A** - Express.js is a Node.js web framework.
22. **D** - useState provides state and a setter that can trigger a re-render.
23. **B** - Angular applications are primarily written in TypeScript.
24. **A** - React Native supports Android and iOS from a shared codebase.
25. **C** - Kotlin and Android Studio are used for native Android development.

## Section B - Short answers (30 marks)

### B1. Website and web application

A website primarily presents information, such as a company brochure site. A web application lets users perform tasks and process data, such as Gmail sending and organising messages. Both use web technologies; many modern sites include application features.

### B2. CSS box model

An element consists of content, padding, border and margin, from inside to outside. Padding is space between the content and border; margin is space outside the border. With box-sizing: border-box, the declared width includes the content, padding and border, but excludes margin.

### B3. Bootstrap grid

Bootstrap uses containers, rows and a 12-column grid. Column classes specify how much of a row an element occupies. For example, col-12 col-md-4 stacks items on small screens and places three equal columns on medium screens and above. Breakpoint classes adapt the layout to available width.

### B4. var, let and const

var is function-scoped, permits redeclaration and reassignment, and is hoisted with an initial value of undefined; avoid it in new block-scoped code. let is block-scoped and suits values that change. const is block-scoped, must be initialised and cannot be reassigned; use it by default when the binding stays the same. Properties of a const object can still change.

### B5. GET and POST

GET places form data in the URL query string and is suitable for retrieval, searches and shareable filters. POST sends fields in the request body and is suitable for submissions that change data. Use POST for login so credentials do not appear in the URL. HTTPS is still required: POST alone does not encrypt data.

### B6. Primary and foreign keys

A primary key is a unique, non-null identifier for a row, such as courses.id. A foreign key references a key in another table, such as registrations.course_id referencing courses.id. Together they link related records, enforce referential integrity and reduce duplicated data.

### B7. SQL injection

SQL injection occurs when untrusted input changes the structure of a database query. Prevent it by using PDO prepared statements with bound parameters, or Laravel Eloquent/query-builder parameter binding instead of concatenating input into SQL. Also validate input and allow-list dynamic column names; placeholders cannot bind SQL identifiers.

### B8. Laravel MVC

The Model represents data and relationships, usually through Eloquent. The View renders the user interface using Blade. The Controller handles a request, validates input, works with models and returns a view or response. The route file maps an HTTP method and URL to the relevant controller action.

### B9. REST API and CRUD

A REST API exposes resources through URLs using a stateless request/response style. GET reads resources, POST creates them, PUT replaces or updates a resource, and DELETE removes it. JSON is the usual response format. For example, GET /api/courses reads courses, with HTTP status codes describing the outcome.

### B10. Native and cross-platform mobile apps

Native apps target a particular platform using its languages and SDKs, for example Kotlin with Android Studio for Android. Cross-platform apps share much of their code across platforms, for example React Native for Android and iOS. Native development offers direct platform integration but usually requires separate codebases; cross-platform development reduces duplication but may still need platform-specific modules.

## Section C - Code writing (25 marks)

### C1. Responsive Bootstrap layout

The four-column width at md and above produces three cards per row; col-12 stacks them on smaller screens. Bootstrap CSS is included locally in the package.

```html
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Three responsive cards</title>
  <link rel="stylesheet" href="../../portal/public/assets/bootstrap.min.css">
</head>
<body>
<section class="container py-5" aria-label="Courses">
  <div class="row g-4">
    <div class="col-12 col-md-4">
      <div class="card h-100"><div class="card-body">
        <h2 class="card-title h5">HTML</h2>
        <p class="card-text">Learn to structure accessible web pages.</p>
        <a href="#html" class="btn btn-primary">Learn HTML</a>
      </div></div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card h-100"><div class="card-body">
        <h2 class="card-title h5">CSS</h2>
        <p class="card-text">Style pages and build responsive layouts.</p>
        <a href="#css" class="btn btn-primary">Learn CSS</a>
      </div></div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card h-100"><div class="card-body">
        <h2 class="card-title h5">JavaScript</h2>
        <p class="card-text">Add interactive behaviour to your pages.</p>
        <a href="#javascript" class="btn btn-primary">Learn JavaScript</a>
      </div></div>
    </div>
  </div>
</section>
</body>
</html>
```

### C2. JavaScript form validation

Return false to block submission. textContent safely displays errors. This meets the question's simple @ test; real applications also require server-side validation.

```javascript
function validateForm() {
  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value;
  const error = document.getElementById('error');
  const messages = [];
  if (name === '') messages.push('Name is required.');
  if (!email.includes('@')) messages.push('Email must contain @.');
  if (password.length < 8) {
    messages.push('Password must contain at least 8 characters.');
  }
  error.textContent = messages.join(' ');
  return messages.length === 0;
}
```

### C3. PHP and MySQL using PDO

The college database and students table must exist. See practicals/C3/college.sql and the accompanying form. Configure credentials for your server.

```php
<?php
// Set DB_USER and DB_PASS in your environment before running.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Please submit the POST form.');
}
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
if ($name === '' || strlen($name) > 120 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254) {
    http_response_code(422);
    exit('Enter a name (maximum 120 characters) and a valid email.');
}
try {
    $pdo = new PDO(
        'mysql:host='.(getenv('DB_HOST') ?: '127.0.0.1').
        ';port='.(getenv('DB_PORT') ?: '3306').
        ';dbname=college;charset=utf8mb4',
        getenv('DB_USER') ?: 'root',
        getenv('DB_PASS') ?: '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_EMULATE_PREPARES => false]
    );
    $stmt = $pdo->prepare(
        'INSERT INTO students (name, email) VALUES (:name, :email)'
    );
    $stmt->execute(['name' => $name, 'email' => $email]);
    echo 'Student added successfully.';
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo 'Database connection or insert failed. Please try again later.';
}
```

### C4. Laravel route, controller and Blade

(a) Route - routes/web.php

```php
<?php
// Add to routes/web.php in an existing Laravel application.
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
Route::get('/products', [ProductController::class, 'index']);
```

(b) Controller method - app/Http/Controllers/ProductController.php

```php
<?php
namespace App\Http\Controllers;
use App\Models\Product;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }
}
```

(c) View - resources/views/products/index.blade.php

```blade
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Products</title></head>
<body>
<h1>Products</h1>
<ul>
@forelse ($products as $product)
  <li>{{ $product->name }} - {{ number_format($product->price, 2) }}</li>
@empty
  <li>No products available.</li>
@endforelse
</ul>
</body></html>
```

### C5. Express REST endpoint and React component

(a) Express application - server.js

```javascript
import express from 'express';

const app = express();
app.get('/api/products', (req, res) => {
  res.json([
    { id: 1, name: 'Keyboard', price: 2500 },
    { id: 2, name: 'Mouse', price: 1500 }
  ]);
});
app.listen(3001, '127.0.0.1', () => {
  console.log('Products API: http://127.0.0.1:3001/api/products');
});
```

(b) React function component - src/Products.jsx

```jsx
import React, { useEffect, useState } from 'react';

export default function Products() {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    const controller = new AbortController();
    async function loadProducts() {
      try {
        const response = await fetch('/api/products', {
          signal: controller.signal
        });
        if (!response.ok) throw new Error('Could not load products.');
        setProducts(await response.json());
      } catch (err) {
        if (err.name !== 'AbortError') setError(err.message);
      } finally {
        if (!controller.signal.aborted) setLoading(false);
      }
    }
    loadProducts();
    return () => controller.abort();
  }, []);

  if (loading) return <p>Loading products...</p>;
  if (error) return <p role="alert">{error}</p>;
  return (
    <ul>
      {products.map(product => <li key={product.id}>{product.name}</li>)}
    </ul>
  );
}
```

The runnable example uses Vite to proxy /api to the Express server, so the relative fetch URL works without cross-origin configuration.

## Section D - Course Registration Portal (20 marks)

Project implementation: portal/. Technology: Laravel 13, PHP 8.4.1+ for the supplied lockfile, MySQL-compatible database, Blade, Bootstrap 5 and JavaScript. The frontend is rendered by Laravel; a separate React frontend is not required by Section D.

### Database design

courses has its own primary key. registrations has its own primary key and course_id as a foreign key to courses.id. A unique constraint on (course_id, email) prevents duplicate registration for a course. The users table includes an is_admin flag. A course can have many registrations; each registration belongs to one course. All database changes have migrations.

### Implemented workflows

Visitors can browse and search courses and register with name, email and phone. Admins sign in to add, list, edit and delete courses and view registrations. Authentication and an admin middleware protect management endpoints. Server-side validation returns field errors and preserves input. Passwords are hashed, write forms include CSRF tokens, and Blade escapes displayed values.

### REST endpoint

GET /api/courses returns HTTP 200 and a JSON array of all course records. It exposes course data only. Fees are decimal strings and start_date is serialised by Eloquent. Registrant contact details are available only in the admin view.

### Submission items that still require the candidate

Candidate details, a real hosting URL, a Git repository URL, the five-minute live demonstration and viva must be supplied by the candidate. This package does not claim that a public deployment or remote repository exists. The project guide includes deployment steps and a demo sequence. No separate earlier assignments were supplied; the package covers the practicals stated in this assessment.

### Learning references

- Laravel installation and routing: https://laravel.com/docs/13.x/installation and https://laravel.com/docs/13.x/routing
- PHP PDO: https://www.php.net/manual/en/book.pdo.php
- Bootstrap grid: https://getbootstrap.com/docs/5.3/layout/grid/
- React useEffect: https://react.dev/reference/react/useEffect
- Express routing: https://expressjs.com/en/guide/routing.html
