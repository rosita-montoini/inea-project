<?php
function getAllProjects($pdo) {
    return $pdo->query("SELECT * FROM projects")->fetchAll();
}