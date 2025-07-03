<?php
function getAllTaskComments($pdo) {
    $stmt = $pdo->query("SELECT * FROM task_comments");
    return $stmt->fetchAll();
}

function createTaskComment($pdo, $data) {
    try {
        $datetime = date('Y-m-d H:i:s', strtotime($data['created_at'])); 
        $stmt = $pdo->prepare("
            INSERT INTO task_comments (comment, task_id, user_id, created_at)
            VALUES (:comment, :task_id, :user_id, :created_at)
        ");
        return $stmt->execute([
            'comment' => $data['comment'],
            'task_id' => $data['task_id'],
            'user_id' => $data['user_id'],
            'created_at' =>  $datetime,
        ]);
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'DB insert failed', 'details' => $e->getMessage()]);
        exit;
    }
}