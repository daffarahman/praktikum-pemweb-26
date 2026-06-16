<?php

class ThreadRepository {
    private $pdo;

    // Menginisialisasi instance repository dengan objek koneksi PDO
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Menyimpan data thread atau reply baru ke database
    public function create(Thread $thread) {
        $stmt = $this->pdo->prepare("INSERT INTO ytta_threads (parent_id, author_name, content) VALUES (:parent_id, :author_name, :content)");
        return $stmt->execute([
            'parent_id' => $thread->parent_id,
            'author_name' => substr($thread->author_name, 0, 100),
            'content' => $thread->content
        ]);
    }

    // Memperbarui isi konten dan nama pembuat thread di database
    public function update(Thread $thread) {
        $stmt = $this->pdo->prepare("UPDATE ytta_threads SET author_name = :author_name, content = :content, updated_at = NOW() WHERE id = :id");
        return $stmt->execute([
            'author_name' => substr($thread->author_name, 0, 100),
            'content' => $thread->content,
            'id' => $thread->id
        ]);
    }

    // Menghapus data thread tertentu berdasarkan ID-nya
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM ytta_threads WHERE id = :id");
        return $stmt->execute(['id' => (int)$id]);
    }

    // Mengambil semua data thread lalu menyusunnya ke dalam struktur pohon (root dan replies)
    public function fetchAllAsTree() {
        $stmt = $this->pdo->query("SELECT * FROM ytta_threads ORDER BY created_at ASC");
        $all_threads = $stmt->fetchAll();
        
        $root_threads = [];
        $threads_by_parent = [];
        
        foreach ($all_threads as $row) {
            $thread = new Thread($row);
            if ($thread->parent_id === null) {
                $root_threads[] = $thread;
            } else {
                $threads_by_parent[$thread->parent_id][] = $thread;
            }
        }
        
        return [
            'root' => array_reverse($root_threads),
            'replies' => $threads_by_parent
        ];
    }
}

