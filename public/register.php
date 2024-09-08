<?php
require_once '../config/Database.php';
require_once '../models/User.php';

// Instantiate Database and User model
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Start the session
session_start();

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    if ($password === $confirm_password) {
        if ($user->register($username, $email, $password)) {
            header("Location: login.php"); // Redirect to login page after successful registration
            exit();
        } else {
            $error = "Unable to register. Username or email may already be taken.";
        }
    } else {
        $error = "Passwords do not match.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Interactive Storytelling Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="navbar">
            <h1 class="logo">StoryExplorer</h1>
        </div>
    </header>

    <section class="auth-page">
        <div class="auth-container">
            <h2>Sign Up</h2>
            <form action="#" method="POST">
                <label for="signup-username">Username</label>
                <input type="text" id="signup-username" name="username" placeholder="Choose a username" required>

                <label for="signup-email">Email</label>
                <input type="email" id="signup-email" name="email" placeholder="Enter your email" required>

                <label for="signup-password">Password</label>
                <input type="password" id="signup-password" name="password" placeholder="Choose a password" required>

                <button type="submit" class="auth-button">Sign Up</button>

                <p class="auth-switch">Already have an account? <a href="login.html">Login</a></p>
            </form>
        </div>
    </section>

    
</body>
</html>
