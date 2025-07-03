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

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
        
    if (!$data) {
        http_response_code(400);
        echo json_encode(['error' =>  'Invalid data']);
        exit;
    }

    $comment = createTaskComment($pdo, $data);

    if ($comment) {
        echo json_encode(['success' => true, 'message' => 'Created successfully']);
        exit;
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Creation failed']);
        exit;
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}