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
