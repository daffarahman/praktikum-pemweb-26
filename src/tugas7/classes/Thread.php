<?php

class Thread {
    public $id;
    public $parent_id;
    public $author_name;
    public $content;
    public $created_at;
    public $updated_at;

    public function __construct(array $data = []) {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
        $this->parent_id = isset($data['parent_id']) && $data['parent_id'] !== '' ? (int)$data['parent_id'] : null;
        $this->author_name = $data['author_name'] ?? 'Anonymous';
        $this->content = $data['content'] ?? '';
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }

    public function getFormattedCreatedAt() {
        return $this->formatTwitterDate($this->created_at);
    }

    public function getFormattedUpdatedAt() {
        return $this->updated_at ? $this->formatTwitterDate($this->updated_at) : null;
    }

    public function isEdited() {
        return !empty($this->updated_at);
    }

    private function formatTwitterDate($timestamp_str) {
        if (!$timestamp_str) {
            return '';
        }
        
        $timestamp = strtotime($timestamp_str);
        if (!$timestamp) {
            return $timestamp_str;
        }
        
        $now = time();
        $diff = $now - $timestamp;
        
        if ($diff < 0) {
            $diff = 0;
        }
        
        if ($diff < 60) {
            return "baru saja";
        }
        
        if ($diff < 3600) {
            $mins = floor($diff / 60);
            return "$mins menit lalu";
        }
        
        if ($diff < 86400) {
            $hours = floor($diff / 3600);
            return "$hours jam lalu";
        }
        
        // Bulan dalam bahasa indonesia
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $post_year = (int)date('Y', $timestamp);
        $current_year = (int)date('Y', $now);
        $day = date('j', $timestamp);
        $month_num = (int)date('n', $timestamp);
        $month_name = $months[$month_num] ?? date('M', $timestamp);
        
        if ($post_year === $current_year) {
            return "$day $month_name";
        } else {
            return "$day $month_name $post_year";
        }
    }
}
