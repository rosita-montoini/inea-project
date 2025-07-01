<?php

class ApiService {
    public static function handleRequest($pdo, $getAllFunc, $updateFunc, $createFunc) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $items = $getAllFunc($pdo);
            echo json_encode($items);
            exit;
        
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
        
            if (!$data) {
                http_response_code(400);
                echo json_encode(['error' =>  'Invalid data']);
                exit;
            }
        
            if (isset($data['id']) && !empty($data['id'])) {
                $updateData = $updateFunc($pdo, $data);
        
                if ($updateData) {
                    echo json_encode(['success' => true, 'message' => 'Updated successfully']);
                    exit;
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Update failed']);
                    exit;
                }
            } else {
                $newData = $createFunc($pdo, $data);

                if ($newData) {
                    echo json_encode(['success' => true, 'message' => 'Created successfully', 'id' => $newId]);
                    exit;
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Creation failed']);
                    exit;
                }
            }
        
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }
    }
}