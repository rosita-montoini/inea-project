<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../db.php";
require_once "../services/taskService.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tasks = getAllTasks($pdo);
    echo json_encode($tasks);
    exit;

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid task data']);
        exit;
    }

    if (isset($data['id']) && !empty($data['id'])) {
        $result = updateTask($pdo, $data);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Task updated']);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Task update failed']);
            exit;
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Missing task id']);
        exit;
    }

} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}