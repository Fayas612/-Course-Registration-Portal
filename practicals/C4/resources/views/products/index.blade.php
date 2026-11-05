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
