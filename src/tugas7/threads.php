<?php
// Memuat file autoloader class
require_once __DIR__ . '/autoload.php';

// Memastikan koneksi database PDO sudah tersedia
if (!isset($pdo)) {
    $database = new Database();
    $pdo = $database->getConnection();
}

// Mengambil seluruh data thread dan membaginya ke dalam struktur pohon (root dan replies)
$threadRepository = new ThreadRepository($pdo);
$tree = $threadRepository->fetchAllAsTree();

// Menyimpan daftar thread utama dan daftar balasan masing-masing parent thread
$root_threads = $tree['root'];
$threads_by_parent = $tree['replies'];

// Fungsi pembantu kompatibilitas untuk merender thread secara rekursif
function render_thread($thread, $threads_by_parent, $csrf_token, $level = 0) {
    $renderer = new ThreadRenderer($csrf_token, $threads_by_parent);
    $renderer->render($thread, $level);
}

// Fungsi pembantu kompatibilitas untuk memformat waktu menjadi waktu relatif ala Twitter/X
function format_twitter_date($timestamp_str) {
    $thread = new Thread(['created_at' => $timestamp_str]);
    return $thread->getFormattedCreatedAt();
}

