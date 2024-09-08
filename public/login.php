<?php
require_once '../config/Database.php';
require_once '../models/User.php';

// Instantiate Database and User model
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    if ($user->login($username, $password)) {
        $_SESSION['user_id'] = $user->getUserId($username);
        header("Location: index.php"); 
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Interactive Storytelling Platform</title>
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
            <h2>Login</h2>
            <form action="#" method="POST">
                <label for="login-email">Email</label>
                <input type="email" id="login-email" name="email" placeholder="Enter your email" required>

                <label for="login-password">Password</label>
                <input type="password" id="login-password" name="password" placeholder="Enter your password" required>

                <button type="submit" class="auth-button">Login</button>

                <p class="auth-switch">Don't have an account? <a href="register.php">Sign up</a></p>
            </form>
        </div>
    </section>

    
</body>
</html>
