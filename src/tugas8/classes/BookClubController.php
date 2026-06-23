<?php

class BookClubController {
    private $repository;
    private $error_message = '';
    private $success_message = '';

    // Menginisialisasi controller dengan dependensi repository
    public function __construct(BookClubRepository $repository) {
        $this->repository = $repository;
    }

    // Menangani request pendaftaran
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validasi CSRF Token
            $csrf_token = $_POST['csrf_token'] ?? '';
            if (!SessionManager::validateCsrfToken($csrf_token)) {
                $this->error_message = 'Keamanan form tidak valid (CSRF token invalid). Silakan coba lagi.';
                return;
            }

            // Sanitasi data input
            $nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $no_telp = isset($_POST['no_telp']) ? trim($_POST['no_telp']) : '';
            $buku_dibawa = isset($_POST['buku_dibawa']) ? trim($_POST['buku_dibawa']) : '';
            $jenis_buku = isset($_POST['jenis_buku']) ? trim($_POST['jenis_buku']) : '';

            // Validasi jangan sampai kosong
            if ($nama === '' || $email === '' || $no_telp === '' || $buku_dibawa === '' || $jenis_buku === '') {
                $this->error_message = 'Semua kolom wajib diisi dan tidak boleh kosong.';
                return;
            }

            // Validasi email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->error_message = 'Format email tidak valid.';
                return;
            }

            // Validasi nomor telepon Indonesia
            // Mendukung format: 08..., 628..., +628... dengan panjang total digit (tanpa prefix) berkisar 8-12 digit
            $phone_pattern = '/^(?:\+62|62|0)8[1-9][0-9]{7,11}$/';
            if (!preg_match($phone_pattern, $no_telp)) {
                $this->error_message = 'Nomor telepon harus nomor Indonesia yang valid (mulai dengan 08, 628, atau +628).';
                return;
            }

            // Validasi jenis buku
            if ($jenis_buku !== 'fiksi' && $jenis_buku !== 'nonfiksi') {
                $this->error_message = 'Jenis buku yang dipilih tidak valid.';
                return;
            }

            // Simpan ke database
            $registration = new BookClubRegistration([
                'nama' => $nama,
                'email' => $email,
                'no_telp' => $no_telp,
                'buku_dibawa' => $buku_dibawa,
                'jenis_buku' => $jenis_buku
            ]);

            try {
                if ($this->repository->save($registration)) {
                    // Redirect untuk mencegah resubmission (PRG pattern)
                    header('Location: index.php?status=success');
                    exit;
                } else {
                    $this->error_message = 'Gagal menyimpan data pendaftaran.';
                }
            } catch (PDOException $e) {
                // Jangan ekspos detail SQL error ke user
                error_log("Database Error: " . $e->getMessage());
                $this->error_message = 'Terjadi kesalahan pada sistem database. Silakan coba beberapa saat lagi.';
            }
        }

        // Tampilkan pesan sukses jika status redirect diset ke success
        if (isset($_GET['status']) && $_GET['status'] === 'success') {
            $this->success_message = 'Pendaftaran berhasil! Data Anda telah disimpan.';
        }
    }

    // Mengambil pesan error
    public function getErrorMessage() {
        return $this->error_message;
    }

    // Mengambil pesan sukses
    public function getSuccessMessage() {
        return $this->success_message;
    }

    // Mengambil daftar orang yang mendaftar
    public function getRegistrations() {
        try {
            return $this->repository->getAll();
        } catch (PDOException $e) {
            error_log("Failed to fetch registrations: " . $e->getMessage());
            return [];
        }
    }
}
