<?php

function getAllTasks($pdo) {
    $stmt = $pdo->query("
        SELECT t.id, t.title, t.status, p.name AS project_name, u.name AS assigned_to
        FROM tasks t
        LEFT JOIN projects p ON t.project_id = p.id
        LEFT JOIN users u ON t.assigned_to = u.id
    ");
    return $stmt->fetchAll();
}