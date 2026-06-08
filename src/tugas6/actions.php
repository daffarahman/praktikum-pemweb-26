<?php

/**
 * Jadi karena semua HTTP request nya dilakuin di satu file php makanya saya
 * taruh cek untuk setiap metode di satu file ini
 */

// Dump untuk pesan error
$error_message = '';

// Jika methode nya POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Validasi CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed.');
    }

    $action = $_POST['action'] ?? '';

    // Cek aksi yang dilakukan
    if ($action === 'create') {

        // Membuat thread / reply baru
        $parent_id = isset($_POST['parent_id']) && $_POST['parent_id'] !== '' ? (int)$_POST['parent_id'] : null;
        $author_name = trim($_POST['author_name'] ?? '');
        if ($author_name === '') {
            $author_name = 'Anonymous';
        }
        $content = trim($_POST['content'] ?? '');

        if ($content === '') {
            // Error apabila tidak ada konten
            $error_message = 'Content is required.';
        } else {
            try {
                // Melakukan insert data
                $stmt = $pdo->prepare("INSERT INTO ytta_threads (parent_id, author_name, content) VALUES (:parent_id, :author_name, :content)");
                $stmt->execute([
                    'parent_id' => $parent_id,
                    'author_name' => substr($author_name, 0, 100),
                    'content' => $content
                ]);
                // Redirect ke index.php
                header("Location: index.php");
                exit;
            } catch (PDOException $e) {
                error_log("Failed to insert thread: " . $e->getMessage());
                $error_message = 'Failed to submit thread.';
            }
        }
    // Jika metodenya update
    } elseif ($action === 'update') {
        $thread_id = (int)($_POST['thread_id'] ?? 0);
        $author_name = trim($_POST['author_name'] ?? '');
        if ($author_name === '') {
            $author_name = 'Anonymous';
        }
        $content = trim($_POST['content'] ?? '');

        if ($content === '') {
            $error_message = 'Content is required for updating.';
        } else {
            try {
                $stmt = $pdo->prepare("UPDATE ytta_threads SET author_name = :author_name, content = :content, updated_at = NOW() WHERE id = :id");
                $stmt->execute([
                    'author_name' => substr($author_name, 0, 100),
                    'content' => $content,
                    'id' => $thread_id
                ]);
                header("Location: index.php");
                exit;
            } catch (PDOException $e) {
                error_log("Failed to update thread: " . $e->getMessage());
                $error_message = 'Failed to update thread.';
            }
        }
    // Jika metodenya delete
    } elseif ($action === 'delete') {
        $thread_id = (int)($_POST['thread_id'] ?? 0);
        try {
            $stmt = $pdo->prepare("DELETE FROM ytta_threads WHERE id = :id");
            $stmt->execute(['id' => $thread_id]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            error_log("Failed to delete thread: " . $e->getMessage());
            $error_message = 'Failed to delete thread.';
        }
    }
}
