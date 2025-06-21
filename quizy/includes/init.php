<?php
session_start();

$baseUrl = '/quizy';

$_SESSION['user_id'] = $_SESSION['user_id'] ?? null;
$_SESSION['username'] = $_SESSION['username'] ?? null;
$_SESSION['role'] = $_SESSION['role'] ?? null;


function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
require_once __DIR__ . '/../config/db.php';
$pdo = getDbConnection();
?>