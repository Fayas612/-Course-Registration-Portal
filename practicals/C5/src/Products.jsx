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
