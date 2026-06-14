<?php
$status  = $_GET['status'] ?? '';
$message = $_GET['message'] ?? '';

function e($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Buku Tamu Digital</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php">
            <span class="brand-badge"><i class="bi bi-journal-bookmark-fill"></i></span>
            Buku Tamu Digital
        </a>
        <div class="ms-auto">
            <a href="daftar_tamu.php" class="btn btn-light btn-sm px-3 rounded-pill">
                <i class="bi bi-table me-1"></i> Daftar Tamu
            </a>
        </div>
    </div>
</nav>

<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="soft-label mb-3 d-inline-block">
                    <i class="bi bi-stars me-1"></i> Sistem Buku Tamu Modern
                </span>
                <h1 class="display-5 fw-bold mb-3 text-white">
                    Selamat Datang di Buku Tamu Digital Sekolah
                </h1>
                <p class="lead text-white-50 mb-4">
                    Silakan isi data kedatangan Anda melalui formulir berikut. Sistem akan mencatat data tamu dengan rapi, cepat, dan profesional.
                </p>

                <div class="hero-info d-flex flex-wrap gap-3">
                    <div class="info-chip">
                        <i class="bi bi-shield-check me-2"></i> Aman & Tertata
                    </div>
                    <div class="info-chip">
                        <i class="bi bi-phone me-2"></i> Responsif
                    </div>
                    <div class="info-chip">
                        <i class="bi bi-clock-history me-2"></i> Timestamp Otomatis
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="glass-card p-4 p-md-5">
                    <div class="mb-4">
                        <h3 class="fw-bold mb-1">Formulir Tamu</h3>
                        <p class="text-muted mb-0">
                            Mohon isi data dengan lengkap dan benar.
                        </p>
                    </div>

                    <?php if ($status === 'success'): ?>
                        <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Data tamu berhasil disimpan.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php elseif ($status === 'error'): ?>
                        <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= e($message ?: 'Terjadi kesalahan. Silakan coba lagi.') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="simpan_tamu.php" method="POST">
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama lengkap" maxlength="100" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="instansi" class="form-label fw-semibold">Instansi</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                <input type="text" name="instansi" id="instansi" class="form-control" placeholder="Masukan asal instansi" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="tujuan" class="form-label fw-semibold">Tujuan Kedatangan</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text align-items-start pt-3"><i class="bi bi-chat-left-text"></i></span>
                                <textarea name="tujuan" id="tujuan" rows="4" class="form-control" placeholder="Tuliskan tujuan kedatangan Anda" required></textarea>
                            </div>
                        </div>

                        <div class="auto-time-note mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            Tanggal dan waktu kedatangan akan dicatat otomatis saat tombol submit ditekan.
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-modern">
                                <i class="bi bi-send-check me-2"></i> Simpan Data Tamu
                            </button>
                            <a href="daftar_tamu.php" class="btn btn-outline-secondary rounded-3">
                                <i class="bi bi-table me-2"></i> Lihat Daftar Tamu
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
