<?php
require_once 'koneksi.php';

function e($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

$q = trim($_GET['q'] ?? '');

$totalTamu = 0;
$tamuHariIni = 0;

$resultTotal = $koneksi->query("SELECT COUNT(*) AS total FROM buku_tamu");
if ($resultTotal) {
    $row = $resultTotal->fetch_assoc();
    $totalTamu = (int)$row['total'];
}

$today = date('Y-m-d');
$stmtToday = $koneksi->prepare("SELECT COUNT(*) AS total FROM buku_tamu WHERE tanggal = ?");
$stmtToday->bind_param("s", $today);
$stmtToday->execute();
$resToday = $stmtToday->get_result();
if ($resToday) {
    $rowToday = $resToday->fetch_assoc();
    $tamuHariIni = (int)$rowToday['total'];
}

if ($q !== '') {
    $keyword = "%{$q}%";
    $stmt = $koneksi->prepare("
        SELECT *
        FROM buku_tamu
        WHERE nama LIKE ? OR instansi LIKE ?
        ORDER BY tanggal DESC, waktu DESC, id DESC
    ");
    $stmt->bind_param("ss", $keyword, $keyword);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $koneksi->query("
        SELECT *
        FROM buku_tamu
        ORDER BY tanggal DESC, waktu DESC, id DESC
    ");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tamu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="page-light">

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php">
            <span class="brand-badge"><i class="bi bi-journal-bookmark-fill"></i></span>
            Buku Tamu Digital
        </a>
        <div class="ms-auto">
            <a href="index.php" class="btn btn-light btn-sm px-3 rounded-pill">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Form
            </a>
        </div>
    </div>
</nav>

<section class="py-5">
    <div class="container">
        <div class="page-header-card mb-4">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <span class="soft-label dark mb-3 d-inline-block">
                        <i class="bi bi-people-fill me-1"></i> Halaman Daftar Tamu
                    </span>
                    <h2 class="fw-bold mb-2">Riwayat Data Tamu Sekolah</h2>
                    <p class="text-muted mb-0">
                        Halaman ini menampilkan seluruh data tamu yang telah mengisi formulir. Anda juga dapat melakukan pencarian berdasarkan nama atau instansi.
                    </p>
                </div>
                <div class="col-lg-5">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon bg-primary-subtle text-primary">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div>
                                    <div class="stat-value"><?= $totalTamu ?></div>
                                    <div class="stat-label">Total Tamu</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon bg-success-subtle text-success">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div>
                                    <div class="stat-value"><?= $tamuHariIni ?></div>
                                    <div class="stat-label">Hari Ini</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-section-card mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                    <form method="GET" action="daftar_tamu.php">
                        <div class="input-group search-modern">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input
                                type="text"
                                name="q"
                                class="form-control"
                                placeholder="Cari berdasarkan nama atau instansi..."
                                value="<?= e($q) ?>"
                            >
                            <button class="btn btn-primary btn-modern" type="submit">Cari</button>
                            <a href="daftar_tamu.php" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <span class="result-note">
                        <?php if ($q !== ''): ?>
                            Menampilkan hasil pencarian untuk: <strong>"<?= e($q) ?>"</strong>
                        <?php else: ?>
                            Menampilkan seluruh data tamu
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="table-section-card">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle modern-table mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Instansi</th>
                            <th>Tujuan</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php $no = 1; ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="fw-semibold"><?= e($row['nama']) ?></td>
                                    <td><?= e($row['instansi']) ?></td>
                                    <td><?= e($row['tujuan']) ?></td>
                                    <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                                    <td><?= date('H:i', strtotime($row['waktu'])) ?> WIB</td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                                        <h5 class="fw-bold">Belum ada data tamu</h5>
                                        <p class="text-muted mb-0">
                                            Data akan muncul di sini setelah tamu mengisi formulir.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
