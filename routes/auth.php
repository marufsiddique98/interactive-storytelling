<?php
require_once '../config/database.php';
require_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'register') {
        $user->username = $_POST['username'];
        $user->email = $_POST['email'];
        $user->password_hash = $_POST['password'];

        if ($user->create()) {
            echo json_encode(["message" => "User created successfully."]);
        } else {
            echo json_encode(["message" => "Unable to create user."]);
        }
    } elseif ($_POST['action'] === 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $loggedInUser = $user->login($email, $password);

        if ($loggedInUser) {
            echo json_encode($loggedInUser);
        } else {
            echo json_encode(["message" => "Invalid credentials."]);
        }
    }
}
