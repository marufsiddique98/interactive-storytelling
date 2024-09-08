<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/auth':
        require __DIR__ . '/../routes/auth.php';
        break;
    case '/stories':
        require __DIR__ . '/../routes/stories.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(["message" => "Not Found"]);
        break;
}
