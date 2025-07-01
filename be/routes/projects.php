<?php
require_once "../db.php";
require_once "../services/projectService.php";

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $projects = getAllProjects($pdo);
    echo json_encode($projects);
}