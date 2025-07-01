<?php
function getAllTasks($pdo) {
    $stmt = $pdo->query("
        SELECT 
            id, 
            title, 
            status, 
            project_id,
            assigned_to
        FROM tasks
    ");
    return $stmt->fetchAll();
}

function updateTask($pdo, $task) {
    $stmt = $pdo->prepare("
        UPDATE tasks SET title = ?, status = ?, project_id = ?, assigned_to = ? 
        WHERE id = ?
    ");
    return $stmt->execute([
        $task['title'],
        $task['status'],
        $task['project_id'],
        $task['assigned_to'],
        $task['id']
    ]);
}

function createTask($pdo, $task) {
    $stmt = $pdo->prepare("
        INSERT INTO tasks (title, status, project_id, assigned_to)
        VALUES (:title, :status, :project_id, :assigned_to)
    ");
    return $stmt->execute([
        'title' => $task['title'],
        'status' => $task['status'],
        'project_id' => $task['project_id'],
        'assigned_to' => $task['assigned_to'],
    ]);
}