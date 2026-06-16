<?php
require_once __DIR__ . '/autoload.php';

// We assume $pdo is already initialized from db.php which is loaded first.
// If not, we fall back to creating a new Database connection.
if (!isset($pdo)) {
    $database = new Database();
    $pdo = $database->getConnection();
}

$threadRepository = new ThreadRepository($pdo);
$tree = $threadRepository->fetchAllAsTree();

$root_threads = $tree['root'];
$threads_by_parent = $tree['replies'];

/**
 * Compatibility helper function for rendering a thread recursively.
 */
function render_thread($thread, $threads_by_parent, $csrf_token, $level = 0) {
    $renderer = new ThreadRenderer($csrf_token, $threads_by_parent);
    $renderer->render($thread, $level);
}

/**
 * Compatibility helper function for formatting twitter date.
 */
function format_twitter_date($timestamp_str) {
    $thread = new Thread(['created_at' => $timestamp_str]);
    return $thread->getFormattedCreatedAt();
}

