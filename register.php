<?php
session_start();
require_once 'Database.php';
require_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = (new Database())->connect();
    $userModel = new User($db);

    if ($userModel->register($name, $email, $username, $password)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Error during registration.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <h1>Create an Account</h1>
        <form action="register.php" method="POST">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="action" value="register">Register</button>
        </form>
        <p class="error"><?php echo isset($error) ? $error : ''; ?></p>
        <a href="index.php" class="link">Already have an account? Login here</a>
    </div>
</body>
</html>
