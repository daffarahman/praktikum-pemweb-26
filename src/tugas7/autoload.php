<?php

// Mengaktifkan autoload untuk class
spl_autoload_register(function ($class) {
    // Mencari class di folder classes
    $file = __DIR__ . '/classes/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
