<?php

class BookClubRegistration {
    private $id;
    private $nama;
    private $email;
    private $no_telp;
    private $buku_dibawa;
    private $jenis_buku;
    private $created_at;

    // Menginisialisasi objek pendaftaran dengan data input
    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->nama = $data['nama'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->no_telp = $data['no_telp'] ?? '';
        $this->buku_dibawa = $data['buku_dibawa'] ?? '';
        $this->jenis_buku = $data['jenis_buku'] ?? '';
        $this->created_at = $data['created_at'] ?? null;
    }

    // Mengambil ID pendaftaran
    public function getId() {
        return $this->id;
    }

    // Mengambil nama pendaftar
    public function getNama() {
        return $this->nama;
    }

    // Mengambil email pendaftar
    public function getEmail() {
        return $this->email;
    }

    // Mengambil nomor telepon pendaftar
    public function getNoTelp() {
        return $this->no_telp;
    }

    // Mengambil judul buku yang dibawa
    public function getBukuDibawa() {
        return $this->buku_dibawa;
    }

    // Mengambil jenis buku (fiksi / nonfiksi)
    public function getJenisBuku() {
        return $this->jenis_buku;
    }

    // Mengambil waktu pembuatan data pendaftaran
    public function getCreatedAt() {
        return $this->created_at;
    }
}
