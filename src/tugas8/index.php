<?php
/**
 * Nama : Muhammad Daffa Rahman
 * NIM  : L0124062
 */


// Meload file autoloader class
require_once __DIR__ . '/autoload.php';

// Menginisialisasi token CSRF untuk keamanan form
$csrf_token = SessionManager::generateCsrfToken();

// File koneksi database dan penanganan request
require_once 'db.php';
require_once 'actions.php';

// Mengambil daftar pendaftar
$registrations = $controller->getRegistrations();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Book Club</title>
    <link rel="stylesheet" href="style.css?v=<?php echo filemtime('style.css'); ?>">
    <script src="script.js?v=<?php echo filemtime('script.js'); ?>" defer></script>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="card">
            <h1>Pendaftaran Book Club</h1>
            <p class="subtitle">Silakan isi formulir di bawah ini untuk mendaftarkan diri Anda pada book club kami.</p>
        </header>

        <!-- Message Alerts -->
        <?php if ($error_message !== ''): ?>
            <div class="alert alert-error">
                <strong>Gagal:</strong> <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <?php if ($success_message !== ''): ?>
            <div class="alert alert-success">
                <strong>Sukses:</strong> <?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <!-- Form Pendaftaran -->
        <section class="card">
            <h2>Formulir Pendaftaran</h2>
            <form method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required placeholder="Masukkan nama lengkap Anda">
                </div>
                
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" required placeholder="nama@domain.com">
                </div>
                
                <div class="form-group">
                    <label for="no_telp">Nomor Telepon (Indonesia)</label>
                    <input type="text" id="no_telp" name="no_telp" required placeholder="Contoh: 081234567890 atau +6281234567890">
                </div>
                
                <div class="form-group">
                    <label for="buku_dibawa">Buku yang Ingin Dibawa</label>
                    <input type="text" id="buku_dibawa" name="buku_dibawa" required placeholder="Judul buku yang akan dibahas">
                </div>
                
                <div class="form-group">
                    <label>Jenis Buku</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="jenis_buku" value="fiksi" required>
                            Fiksi
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="jenis_buku" value="nonfiksi" required>
                            Nonfiksi
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="btn">Kirim Pendaftaran</button>
            </form>
        </section>

        <!-- Daftar Pendaftar -->
        <section class="card">
            <h2>Daftar Pendaftar</h2>
            <?php if (empty($registrations)): ?>
                <p class="subtitle" style="margin-bottom: 0;">Belum ada pendaftar saat ini. Jadilah yang pertama!</p>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nomor Telepon</th>
                                <th>Buku yang Dibawa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registrations as $reg): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($reg->getNama(), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($reg->getNoTelp(), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($reg->getBukuDibawa(), ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
