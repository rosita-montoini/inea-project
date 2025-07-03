<?php
session_start();
require_once "../../cors.php";
require_once "../../db.php";

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    // hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);
    //insert register user to db
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
    $user = $stmt->execute([$name, $email, $hash]);

    //get new registered user from db
    $userId = $pdo->lastInsertId();
    $stmt = $pdo->prepare("SELECT id, name, email, role FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $newUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($newUser) {
        //save new register user data into session 
        foreach (['id', 'email', 'name', 'role'] as $key) {
            $_SESSION["user_$key"] = $newUser[$key];
        }

        echo json_encode(['success' => true, 'user' => $newUser['name']]);
    } else {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}