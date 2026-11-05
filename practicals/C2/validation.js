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
