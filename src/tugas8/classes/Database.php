<?php

class Database {
    private $pdo;

    // Menghubungkan ke database dengan PDO dan menginisialisasi tabel
    public function __construct() {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $dbname = getenv('DB_NAME') ?: 'praktikum_pemweb';
        $username = getenv('DB_USER') ?: 'pemweb_user';
        $password = getenv('DB_PASS') ?: 'pemweb_password';

        // String koneksi
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

        try {
            // membuat PDO baru
            $this->pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);

            $this->initializeTable();
        } catch (PDOException $e) {
            error_log("Database connection or initialization failed: " . $e->getMessage());
            die("Error: Connection to database failed. Please try again later.");
        }
    }

    // Membuat tabel bookshopdap_club jika belum ada di database
    private function initializeTable() {
        // Create table if not exists for book club registration
        $sql = "CREATE TABLE IF NOT EXISTS bookshopdap_club (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            no_telp VARCHAR(50) NOT NULL,
            buku_dibawa VARCHAR(255) NOT NULL,
            jenis_buku ENUM('fiksi', 'nonfiksi') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
        $this->pdo->exec($sql);
    }

    // Mengembalikan instance koneksi PDO
    public function getConnection() {
        return $this->pdo;
    }
}

