<?php

class ThreadController {
    private $repository;
    private $errorMessage = '';

    public function __construct(ThreadRepository $repository) {
        $this->repository = $repository;
    }

    public function getErrorMessage() {
        return $this->errorMessage;
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrfToken = $_POST['csrf_token'] ?? '';
            if (!SessionManager::validateCsrfToken($csrfToken)) {
                die('CSRF token validation failed.');
            }

            $action = $_POST['action'] ?? '';

            if ($action === 'create') {
                $parentId = isset($_POST['parent_id']) && $_POST['parent_id'] !== '' ? (int)$_POST['parent_id'] : null;
                $authorName = trim($_POST['author_name'] ?? '');
                if ($authorName === '') {
                    $authorName = 'Anonymous';
                }
                $content = trim($_POST['content'] ?? '');

                if ($content === '') {
                    $this->errorMessage = 'Content is required.';
                } else {
                    try {
                        $thread = new Thread([
                            'parent_id' => $parentId,
                            'author_name' => $authorName,
                            'content' => $content
                        ]);
                        $this->repository->create($thread);
                        header("Location: index.php");
                        exit;
                    } catch (PDOException $e) {
                        error_log("Failed to insert thread: " . $e->getMessage());
                        $this->errorMessage = 'Failed to submit thread.';
                    }
                }
            } elseif ($action === 'update') {
                $threadId = (int)($_POST['thread_id'] ?? 0);
                $authorName = trim($_POST['author_name'] ?? '');
                if ($authorName === '') {
                    $authorName = 'Anonymous';
                }
                $content = trim($_POST['content'] ?? '');

                if ($content === '') {
                    $this->errorMessage = 'Content is required for updating.';
                } else {
                    try {
                        $thread = new Thread([
                            'id' => $threadId,
                            'author_name' => $authorName,
                            'content' => $content
                        ]);
                        $this->repository->update($thread);
                        header("Location: index.php");
                        exit;
                    } catch (PDOException $e) {
                        error_log("Failed to update thread: " . $e->getMessage());
                        $this->errorMessage = 'Failed to update thread.';
                    }
                }
            } elseif ($action === 'delete') {
                $threadId = (int)($_POST['thread_id'] ?? 0);
                try {
                    $this->repository->delete($threadId);
                    header("Location: index.php");
                    exit;
                } catch (PDOException $e) {
                    error_log("Failed to delete thread: " . $e->getMessage());
                    $this->errorMessage = 'Failed to delete thread.';
                }
            }
        }
    }
}
