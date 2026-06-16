<?php
// Memuat file autoloader class
require_once __DIR__ . '/autoload.php';

// Memastikan koneksi database PDO sudah tersedia
if (!isset($pdo)) {
    $database = new Database();
    $pdo = $database->getConnection();
}

// Inisialisasi repositori dan kontroler untuk mengelola thread
$repository = new ThreadRepository($pdo);
$controller = new ThreadController($repository);

// Menjalankan penanganan request dan mengambil pesan error jika terjadi kesalahan
$controller->handleRequest();
$error_message = $controller->getErrorMessage();

