<?php
session_start();
session_destroy();
require_once "../../cors.php";
echo json_encode(['success' => true]);
?>