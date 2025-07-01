<?php
function getAllUsers($pdo) {
    return $pdo->query("SELECT * FROM users")->fetchAll();
}