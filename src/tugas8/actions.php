<?php
// Memuat file autoloader class
require_once __DIR__ . '/autoload.php';

// Memastikan koneksi database PDO sudah tersedia
if (!isset($pdo)) {
    $database = new Database();
    $pdo = $database->getConnection();
}

// Inisialisasi repositori dan kontroler untuk mengelola pendaftaran book club
$repository = new BookClubRepository($pdo);
$controller = new BookClubController($repository);

// Menjalankan penanganan request dan mengambil pesan status jika terjadi sesuatu
$controller->handleRequest();
$error_message = $controller->getErrorMessage();
$success_message = $controller->getSuccessMessage();
