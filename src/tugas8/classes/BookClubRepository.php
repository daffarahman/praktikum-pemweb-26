<?php

class BookClubRepository {
    private $pdo;

    // Menginisialisasi objek repository dengan koneksi PDO
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Menyimpan pendaftaran baru
    public function save(BookClubRegistration $registration) {
        $sql = "INSERT INTO bookshopdap_club (nama, email, no_telp, buku_dibawa, jenis_buku) 
                VALUES (:nama, :email, :no_telp, :buku_dibawa, :jenis_buku)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nama' => $registration->getNama(),
            ':email' => $registration->getEmail(),
            ':no_telp' => $registration->getNoTelp(),
            ':buku_dibawa' => $registration->getBukuDibawa(),
            ':jenis_buku' => $registration->getJenisBuku()
        ]);
    }

    // Mengambil semua data pendaftaran
    public function getAll() {
        $sql = "SELECT * FROM bookshopdap_club ORDER BY created_at DESC";
        $stmt = $this->pdo->query($sql);
        
        $registrations = [];
        while ($row = $stmt->fetch()) {
            $registrations[] = new BookClubRegistration($row);
        }
        return $registrations;
    }
}
