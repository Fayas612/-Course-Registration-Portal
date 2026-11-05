# Section C practical files

These exercises are independent of the Section D portal unless noted below.

## C1 - Bootstrap layout
Open C1/cards.html in a browser. Its stylesheet points to the bundled Bootstrap file in portal/public/assets. Resize the browser: one card per row below 768px and three from 768px upward. Buttons are illustrative fragment links, as no target pages are specified by the question.

## C2 - JavaScript validation
Open C2/index.html. Empty name, missing @, and passwords shorter than eight characters block submission. Valid inputs navigate to a demonstration success page. This is a client validation example, not an account system. Password fields deliberately have no name attribute and are not sent in the demonstration URL.

## C3 - PHP/PDO
Import C3/college.sql into a local MySQL-compatible server. Set DB_HOST, DB_PORT, DB_USER and DB_PASS as needed. Run `php -S 127.0.0.1:8081 -t practicals/C3` from the package root, then open http://127.0.0.1:8081/form.html. The database name is college. Use this standalone example locally; the Section D application supplies Laravel CSRF protection for its forms.

## C4 - Laravel/Eloquent/Blade
This is an integration exercise for an existing Laravel application. From the portal directory, copy C4/app/Models/Product.php and C4/app/Http/Controllers/ProductController.php into the corresponding app folders. Copy its Blade view and migration to the corresponding resources and database folders. Append the route (without a second PHP opening tag) to routes/web.php. Run `php artisan migrate`. Add sample rows using `php artisan tinker` and `App\Models\Product::create(['name'=>'Keyboard','price'=>2500]);`. Visit /products. The provided Product model and migration make the example usable even though the question assumes both exist. Do not overwrite the portal's existing route file.

## C5 - Express and React
Requires Node.js 20.19+ or 22.12+. From practicals/C5 run `npm ci`. In one terminal run `npm run api`; in another run `npm run dev`. Open the Vite URL shown in the second terminal. The Vite proxy forwards /api/products to Express on port 3001. `npm run build` creates a production frontend bundle, but that bundle needs a production web server configured to forward /api to Express; the development proxy is not part of the build.
