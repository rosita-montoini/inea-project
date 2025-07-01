<?php
require_once "../db.php";
require_once "../services/userService.php";

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $users = getAllUsers($pdo);
    echo json_encode($users);
}