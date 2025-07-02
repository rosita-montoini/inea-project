<?php
session_start();
require_once "../cors.php";
require_once "../db.php";
require_once "../services/taskService.php";
require_once "../services/ApiService.php";
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

//use service for request handling 
ApiService::handleRequest($pdo, 'getAllTasks', 'updateTask', 'createTask');