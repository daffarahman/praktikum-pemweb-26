<?php
// Memuat file autoloader class
require_once __DIR__ . '/autoload.php';

// Membuat objek Database dan mengambil koneksi PDO
$database = new Database();
$pdo = $database->getConnection();

