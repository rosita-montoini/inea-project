<?php
function getAllTaskComments($pdo) {
    $stmt = $pdo->query("SELECT * FROM task_comments");
    return $stmt->fetchAll();
}