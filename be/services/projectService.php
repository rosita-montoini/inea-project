<?php
function getAllProjects($pdo) {
    return $pdo->query("SELECT * FROM projects")->fetchAll();
}

function updateProject($pdo, $project) {
    $stmt = $pdo->prepare("
        UPDATE projects SET name = ?, description = ? 
        WHERE id = ?
    ");
    return $stmt->execute([
        $project['name'],
        $project['description'],
        $project['id']
    ]);
}

function createProject($pdo, $project) {
    $stmt = $pdo->prepare("
        INSERT INTO projects (name, description)
        VALUES (:name, :description)
    ");
    return $stmt->execute([
        'name' => $project['name'],
        'description' => $project['description']
    ]);
}