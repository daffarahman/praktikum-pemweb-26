<?php
// db.php
// Database connection parameters with automatic host/docker detection
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME') ?: 'praktikum_pemweb';
$username = getenv('DB_USER') ?: 'pemweb_user';
$password = getenv('DB_PASS') ?: 'pemweb_password';

// If DB_HOST environment variable is not defined, we might be running on the host machine
if (!$host) {
    if (gethostbyname('db') !== 'db') {
        $host = 'db';
        $port = '3306';
    } else {
        // Fallback to host port mapping to the container
        $host = '127.0.0.1';
        $port = '3367';
    }
}
if (!$port) {
    $port = '3306';
}

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // Create table if not exists with ytta_ prefix
    $sql = "CREATE TABLE IF NOT EXISTS ytta_threads (
        id INT AUTO_INCREMENT PRIMARY KEY,
        parent_id INT DEFAULT NULL,
        author_name VARCHAR(100) NOT NULL,
        content TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT NULL,
        FOREIGN KEY (parent_id) REFERENCES ytta_threads(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $pdo->exec($sql);
} catch (PDOException $e) {
    error_log("Database connection or initialization failed: " . $e->getMessage());
    die("Error: Connection to database failed. Please try again later.");
}
