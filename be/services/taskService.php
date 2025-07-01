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
    $stmt = $pdo->prepare("UPDATE tasks SET title = ?, status = ?, project_id = ?, assigned_to = ? WHERE id = ?");
    return $stmt->execute([
        $task['title'],
        $task['status'],
        $task['project_id'],
        $task['assigned_to'],
        $task['id']
    ]);
}