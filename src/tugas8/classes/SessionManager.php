<?php

class SessionManager {
    // Memulai session jika session belum aktif
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Menghasilkan token CSRF unik dan menyimpannya di session
    public static function generateCsrfToken() {
        self::start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Memvalidasi apakah token CSRF yang diberikan cocok dengan token di session
    public static function validateCsrfToken($token) {
        self::start();
        return isset($_SESSION['csrf_token']) && $token === $_SESSION['csrf_token'];
    }
}

