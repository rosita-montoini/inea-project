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
require_once "../services/ApiService.php";

header("Content-Type: application/json");

//use service for request handling 
ApiService::handleRequest($pdo, 'getAllTasks', 'updateTask', 'createTask');