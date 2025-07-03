<?php
session_start();
require_once "../cors.php";
require_once "../db.php";
require_once "../services/taskCommentsService.php";
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $comments = getAllTaskComments($pdo);
    echo json_encode($comments);
}