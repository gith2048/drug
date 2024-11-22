<?php
session_start();

// Database connection (Replace with your own DB credentials)
$host = 'localhost';
$dbname = 'Login';
$username = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Process registration
if (isset($_POST['register'])) {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirmPass = $_POST['confirm-password'];

    // Check if passwords match
    if ($pass !== $confirmPass) {
        echo "<script>alert('Passwords do not match.'); window.location.href = 'index.html';</script>";
        exit();
    }

    // Check if username already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $user]);
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<script>alert('Username already taken.'); window.location.href = 'index.html';</script>";
        exit();
    }

    // Hash password and insert into the database
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $stmt->execute([
        'username' => $user,
        'email' => $email,
        'password' => $hashedPassword
    ]);

    echo "<script>alert('Registration successful!'); window.location.href = 'index.html';</script>";
}
?>
