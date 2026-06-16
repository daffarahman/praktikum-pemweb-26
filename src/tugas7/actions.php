<?php
require_once __DIR__ . '/autoload.php';

// We assume $pdo is already initialized from db.php which is loaded first.
// If not, we fall back to creating a new Database connection.
if (!isset($pdo)) {
    $database = new Database();
    $pdo = $database->getConnection();
}

$repository = new ThreadRepository($pdo);
$controller = new ThreadController($repository);

$controller->handleRequest();
$error_message = $controller->getErrorMessage();

