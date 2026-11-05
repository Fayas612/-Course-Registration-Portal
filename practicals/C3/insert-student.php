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
