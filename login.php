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

// Process login
if (isset($_POST['login'])) {
    $user = trim($_POST['username']);  // Trim any extra spaces
    $pass = trim($_POST['password']);  // Trim any extra spaces

    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $user]);
    $userRecord = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debugging: var_dump($userRecord);
    if ($userRecord && password_verify($pass, $userRecord['password'])) {
        // Login successful, start session
        $_SESSION['user_id'] = $userRecord['id'];
        header("Location: dashboard.php"); // Redirect to dashboard or homepage
        exit();
    } else {
        echo "<script>alert('Invalid username or password.'); window.location.href = 'index.php';</script>";
    }
}
?>
