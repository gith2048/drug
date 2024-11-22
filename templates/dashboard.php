<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <?php
    if (isset($_SESSION['success_message'])) {
        echo "<p>" . htmlspecialchars($_SESSION['success_message']) . "</p>";
        unset($_SESSION['success_message']); // Remove message after displaying
    }
    ?>
    <!-- Your dashboard content here -->
</body>
</html>
